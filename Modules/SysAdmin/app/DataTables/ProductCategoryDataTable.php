<?php

namespace Modules\SysAdmin\DataTables;

use Modules\SysAdmin\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoryDataTable extends DataTable
{
    public function query(ProductCategory $model): QueryBuilder
    {
        return $model->newQuery()
            ->with([
                'parent:id,name',
            ])
            ->select(['product_category.*']);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dt = new EloquentDataTable($query);

        // Parent category name
        $dt->addColumn('parent_name', fn($row) => $row->parent?->name ?? '—');

        // Status badge
        $dt->editColumn('status', function (ProductCategory $row) {
            $map   = ProductCategory::$statuses ?? [0 => 'Delete', 1 => 'Published', 2 => 'Draft'];
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

        // Search by parent category name
        $dt->filterColumn('parent_name', function ($query, $keyword) {
            $query->whereHas('parent', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
        });

        return $dt->rawColumns(['status', 'action']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1) // order by 'name'
            ->selectStyleSingle();
            // ->parameters([
            //     'dom'     => 'Bfrtip',
            //     'buttons' => ['export', 'print', 'reset', 'reload'],
            // ])
            // ->buttons([
            //     Button::make('add')->action(
            //         "window.location = '" . route('sysadmin.catalog.productcategory.create') . "';"
            //     ),
            //     Button::make('excel'),
            //     Button::make('reload'),
            // ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->width(60),
            Column::make('name')->title('Category'),
            Column::computed('parent_name')
                ->title('Parent Category')
                ->searchable(true)
                ->orderable(false),
            Column::make('slug')->title('Slug'),
            Column::make('sort')->title('Sort')->width(80),
            Column::make('status')->title('Status')->width(110),
            Column::computed('action')
                ->title('Action')
                ->searchable(false)
                ->orderable(false)
                ->width(100),
        ];
    }

    protected function getActionColumn($data): string
    {
        $showUrl   = route('sysadmin.catalog.productcategory.view', $data->id);
        $editUrl   = route('sysadmin.catalog.productcategory.edit', $data->id);
        $deleteUrl = route('sysadmin.catalog.productcategory.delete', $data->id);

        return '
        <ul class="action">
            <li class="edit">
                <a href="' . $editUrl . '" data-bs-original-title="edit" title="edit">
                    <i class="icon-pencil-alt"></i>
                </a>
            </li>
            <li class="view">
                <a href="' . $showUrl . '" data-bs-original-title="view" title="view">
                    <i class="icon-eye"></i>
                </a>
            </li>
            <li class="delete">
                <a href="' . $deleteUrl . '" data-bs-original-title="delete" title="delete">
                    <i class="icon-trash"></i>
                </a>
            </li>
        </ul>';
    }

    protected function filename(): string
    {
        return 'ProductCategory_' . date('YmdHis');
    }
}
