<?php

namespace Modules\SysAdmin\DataTables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\SysAdmin\Models\AttributeGroup;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AttributeGroupDataTable extends DataTable
{
    public function query(AttributeGroup $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'name', 'slug',  'status']);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query = new EloquentDataTable($query);
        $query->addColumn('action', function ($data) {
            return $this->getActionColumn($data);
        })->setRowId('id');
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('attribute-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom'          => 'Bfrtip',
                'buttons'      => ['export', 'print', 'reset', 'reload'],
            ])
            ->buttons([
                Button::make('add')->action("window.location = '" . route('sysadmin.catalog.attribute.group.create') . "';"),
                Button::make('excel'),
                //Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
                //Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('slug'),
            Column::make('status'),
            Column::make('action')->searchable(false)->orderable(true)->width(100),
        ];
    }

    protected function getActionColumn($data): string
    {
        $showUrl = route('sysadmin.catalog.attribute.group.view', $data->id);
        $editUrl = route('sysadmin.catalog.attribute.group.edit', $data->id);
        $deleteUrl = route('sysadmin.catalog.attribute.group.delete', $data->id);
        return '
        <ul class="action">
            <li class="edit"> <a href="' . $editUrl . '" data-bs-original-title="edit" title="edit"><i class="icon-pencil-alt"></i></a></li>
            <li class="view"> <a href="' . $showUrl . '" data-bs-original-title="view" title="view"><i class="icon-eye"></i></a></li>
            <li class="delete"><a href="' . $deleteUrl . '" data-bs-original-title="delete" title="delete"><i class="icon-trash"></i></a></li>
        </ul>';
    }


    protected function filename(): string
    {
        return 'AttributeGroup_' . date('YmdHis');
    }
}
