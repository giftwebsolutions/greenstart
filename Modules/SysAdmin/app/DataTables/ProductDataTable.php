<?php

namespace Modules\SysAdmin\DataTables;

use Carbon\Carbon;
use Modules\SysAdmin\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Base query with relations
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()
            ->with([
                'category:id,name',
                'subCategory:id,name',
            ])
            ->select([
                'id',
                'title',
                'sku',
                'product_category',
                'sub_product_category',
                'is_featured',
                'status',
                'updated_at',
            ]);
    }

    /**
     * DataTable definition
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = new EloquentDataTable($query);

        $dataTable
            ->addColumn('category_name', function (Product $product) {
                return $product->category?->name ?? '-';
            })
            ->addColumn('sub_category_name', function (Product $product) {
                return $product->subCategory?->name ?? '-';
            })
            ->addColumn('action', function (Product $product) {
                return $this->getActionColumn($product);
            })
            ->editColumn('status', function (Product $product) {
                return Product::$statuses[$product->status] ?? $product->status;
            })
            ->editColumn('is_featured', function (Product $product) {
                return $product->is_featured ? 'Yes' : 'No';
            })
            ->editColumn('slider', function (Product $product) {
                return $product->slider ? 'Yes' : 'No';
            })
            ->editColumn('updated_at', function (Product $product) {
                if (empty($product->updated_at)) {
                    return '';
                }

                // updated_at is UNIX timestamp (int)
                return Carbon::createFromTimestamp($product->updated_at)->format('Y-m-d H:i');
            })
            ->setRowId('id');

        return $dataTable->rawColumns(['action']);
    }

    /**
     * HTML builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('add')->action(
                    "window.location = '" . route('sysadmin.catalog.product.create') . "';"
                ),
                Button::make('excel'),
                Button::make('reload'),
            ]);
    }

    /**
     * Columns definition
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('title'),
            Column::make('sku'),
            Column::make('category_name')
                ->title('Category')
                ->searchable(false)
                ->orderable(false),
            Column::make('sub_category_name')
                ->title('Sub Category')
                ->searchable(false)
                ->orderable(false),
            Column::make('is_featured')
                ->title('Featured')
                ->searchable(false),
            Column::make('status')
                ->searchable(false),
            Column::make('updated_at')
                ->title('Updated At')
                ->searchable(false),
            Column::computed('action')
                ->searchable(false)
                ->orderable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Action column HTML
     */
    protected function getActionColumn(Product $product): string
    {
        $editUrl   = route('sysadmin.catalog.product.edit', $product->id);
        $deleteUrl = route('sysadmin.catalog.product.delete', $product->id);

        return '
        <ul class="action">
            <li class="edit">
                <a href="' . $editUrl . '" data-bs-original-title="edit" title="edit">
                    <i class="icon-pencil-alt"></i>
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
        return 'Products_' . date('YmdHis');
    }
}
