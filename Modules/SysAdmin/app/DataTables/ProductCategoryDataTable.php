<?php

namespace Modules\SysAdmin\DataTables;

use Modules\SysAdmin\Models\ProductCategory;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoryDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (ProductCategory $product) {
                $editUrl   = route('sysadmin.catalog.product.edit', $product->id);
                $deleteUrl = route('sysadmin.catalog.product.destroy', $product->id);

                return view('sysadmin::catalog.product.partials.actions', compact('editUrl', 'deleteUrl'));
            })
            ->editColumn('status', function (ProductCategory $product) {
                return $product->status ? 'Active' : 'Inactive';
            })
            ->editColumn('is_featured', function (ProductCategory $product) {
                return $product->is_featured ? 'Yes' : 'No';
            })
            ->editColumn('slider', function (ProductCategory $product) {
                return $product->slider ? 'Yes' : 'No';
            })
            ->rawColumns(['action']);
    }

   public function query( $model)
{
    return $model->newQuery()
        ->select([
            'id',
            'parent_id',
            'name',
            'description',
            'banner',
            'slug',
            'image',
            'sort',
            'status',
        ]);
}


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'desc');
    }

   protected function getColumns(): array
{
    return [
        Column::make('id'),
        Column::make('parent_id'),
        Column::make('name'),
        Column::make('description'),
        Column::make('banner'),
        Column::make('slug'),
        Column::make('image'),
        Column::make('sort'),
        Column::make('status'),
        Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(120)
            ->addClass('text-center'),
    ];
}


    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}
