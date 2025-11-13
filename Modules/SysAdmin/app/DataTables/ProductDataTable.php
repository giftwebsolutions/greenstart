<?php

namespace Modules\SysAdmin\DataTables;

use Modules\SysAdmin\Models\Product;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Product $product) {
                $editUrl   = route('sysadmin.catalog.product.edit', $product->id);
                $deleteUrl = route('sysadmin.catalog.product.destroy', $product->id);

                return view('sysadmin::catalog.product.partials.actions', compact('editUrl', 'deleteUrl'));
            })
            ->editColumn('status', function (Product $product) {
                return $product->status ? 'Active' : 'Inactive';
            })
            ->editColumn('is_featured', function (Product $product) {
                return $product->is_featured ? 'Yes' : 'No';
            })
            ->editColumn('slider', function (Product $product) {
                return $product->slider ? 'Yes' : 'No';
            })
            ->rawColumns(['action']);
    }

    public function query(Product $model)
    {
        return $model->newQuery()
            ->select([
                'id',
                'title',
                'sku',
                'product_category',
                'sub_product_category',
                'is_featured',
                'slider',
                'status',
                'sort_order',
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
            Column::make('title'),
            Column::make('sku'),
            Column::make('product_category'),
            Column::make('sub_product_category'),
            Column::make('is_featured'),
            Column::make('slider'),
            Column::make('status'),
            Column::make('sort_order'),
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
