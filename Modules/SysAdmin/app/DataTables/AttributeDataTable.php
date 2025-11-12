<?php

namespace Modules\SysAdmin\DataTables;

use Modules\SysAdmin\Models\Attribute;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AttributeDataTable extends DataTable
{
    public function query(Attribute $model): QueryBuilder
    {
        // Eager-load relations to avoid N+1
        return $model->newQuery()
            ->with([
                // select only what we need from relations
                'attribute_group:id,name',
                'attribute_type:attribute_type_id,type_name',
            ])
            ->select(['attribute.*']);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dt = new EloquentDataTable($query);

        // Relation display columns
        $dt->addColumn('group_name', fn($row) => $row->attribute_group?->name ?? '—');
        $dt->addColumn('type_name',  fn($row) => $row->attribute_type?->type_name ?? '—');

        // Boolean badges
        $dt->editColumn(
            'require',
            fn($row) =>
            $row->require
                ? '<span class="badge bg-success">Required</span>'
                : '<span class="badge bg-secondary">Optional</span>'
        );

        $dt->editColumn(
            'comparable',
            fn($row) =>
            $row->comparable
                ? '<span class="badge bg-info">Yes</span>'
                : '<span class="badge bg-light text-muted border">No</span>'
        );

        // Status badge
        $dt->editColumn('status', function ($row) {
            $map = $row->statuses ?? [0 => 'Delete', 1 => 'Published', 2 => 'Draft'];
            $label = $map[$row->status] ?? $row->status;

            return match ((int) $row->status) {
                1       => '<span class="badge bg-primary">' . $label . '</span>',
                2       => '<span class="badge bg-warning text-dark">' . $label . '</span>',
                default => '<span class="badge bg-danger">' . $label . '</span>',
            };
        });

        // Action column
        $dt->addColumn('action', fn($row) => $this->getActionColumn($row))
            ->setRowId('id');

        // Enable searching on relation columns
        $dt->filterColumn('group_name', function ($query, $keyword) {
            $query->whereHas('attribute_group', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
        });

        $dt->filterColumn('type_name', function ($query, $keyword) {
            $query->whereHas('attribute_type', fn($q) => $q->where('type_name', 'like', "%{$keyword}%"));
        });

        // These columns contain HTML
        return $dt->rawColumns(['require', 'comparable', 'status', 'action']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('attribute-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1) // order by 'name'
            ->selectStyleSingle()
            ->parameters([
                'dom'     => 'Bfrtip',
                'buttons' => ['export', 'print', 'reset', 'reload'],
            ])
            ->buttons([
                Button::make('add')->action("window.location = '" . route('sysadmin.catalog.attribute.create') . "';"),
                Button::make('excel'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->width(60),
            Column::make('name')->title('Attribute'),
            Column::computed('group_name')->title('Group')->searchable(true)->orderable(false),
            Column::make('sort_order')->title('Sort')->width(80),
            Column::computed('type_name')->title('Type')->searchable(true)->orderable(false),
            Column::make('comparable')->title('Comparable')->width(110),
            Column::make('require')->title('Required')->width(110),
            Column::make('status')->title('Status')->width(110),
            Column::computed('action')->title('Action')->searchable(false)->orderable(false)->width(100),
        ];
    }

    protected function getActionColumn($data): string
    {
        $showUrl   = route('sysadmin.catalog.attribute.view', $data->id);
        $editUrl   = route('sysadmin.catalog.attribute.edit', $data->id);
        $deleteUrl = route('sysadmin.catalog.attribute.delete', $data->id);

        return '
        <ul class="action">
            <li class="edit"><a href="' . $editUrl . '" data-bs-original-title="edit" title="edit"><i class="icon-pencil-alt"></i></a></li>
            <li class="view"><a href="' . $showUrl . '" data-bs-original-title="view" title="view"><i class="icon-eye"></i></a></li>
            <li class="delete"><a href="' . $deleteUrl . '" data-bs-original-title="delete" title="delete"><i class="icon-trash"></i></a></li>
        </ul>';
    }

    protected function filename(): string
    {
        return 'Attribute_' . date('YmdHis');
    }
}
