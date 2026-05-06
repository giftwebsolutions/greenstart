<?php

namespace Modules\SysAdmin\DataTables;

use Modules\SysAdmin\Models\Enquiry;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class EnquiryDataTable extends DataTable
{
    /**
     * Query source
     */
    public function query(Enquiry $model): QueryBuilder
    {
        return $model->newQuery()
            ->with([
                'category:id,name',
                'product:id,title',
            ])
            ->select(['enquiries.*']);
    }

    /**
     * DataTable definition
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dt = new EloquentDataTable($query);

        /* ---------------- Relation Columns ---------------- */

        $dt->addColumn('category_name', fn($row) => $row->category?->name ?? '—');
        $dt->addColumn('product_name', fn($row) => $row->product?->title ?? '—');

        /* ---------------- Quantity & Price ---------------- */

        $dt->editColumn('qty', fn($row) => number_format($row->qty, 2));
        $dt->editColumn('price', fn($row) => number_format($row->price, 2));
        $dt->editColumn('req_price', fn($row) => number_format($row->req_price, 2));

        /* ---------------- Status Badge ---------------- */

        $dt->editColumn('status', function ($row) {
            $map   = $row->statuses ?? [0 => 'Inactive', 1 => 'Active'];
            $label = $map[$row->status] ?? $row->status;

            return match ((int) $row->status) {
                1       => '<span class="badge bg-success">' . $label . '</span>',
                default => '<span class="badge bg-danger">' . $label . '</span>',
            };
        });

        $dt->editColumn('created_at', function ($row) {
            return Carbon::parse($row->created_at)->format('d-m-Y');
        });

        /* ---------------- Action Column ---------------- */

        $dt->addColumn('action', fn($row) => $this->getActionColumn($row))
            ->setRowId('id');

        /* ---------------- Search on Relations ---------------- */

        $dt->filterColumn('category_name', function ($query, $keyword) {
            $query->whereHas(
                'category',
                fn($q) =>
                $q->where('name', 'like', "%{$keyword}%")
            );
        });

        $dt->filterColumn('product_name', function ($query, $keyword) {
            $query->whereHas(
                'product',
                fn($q) =>
                $q->where('title', 'like', "%{$keyword}%")
            );
        });

        return $dt->rawColumns(['status', 'action']);
    }

    /**
     * HTML builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('enquiry-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->selectStyleSingle()
            ->parameters([
                'dom'     => 'Bfrtip',
                'buttons' => ['export', 'print', 'reset', 'reload'],
            ])
            ->buttons([
                Button::make('add')->action(
                    "window.location = '" . route('sysadmin.enquiry.create') . "';"
                ),
                Button::make('excel'),
                Button::make('reload'),
            ]);
    }

    /**
     * Columns definition
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->width(60),

            Column::make('name')->title('Customer'),
            //Column::make('mobile')->title('Mobile')->width(120),
            Column::make('email')->title('Email'),

            //Column::computed('category_name')->title('Category')->orderable(false),
            //Column::computed('product_name')->title('Product')->orderable(false),

            //Column::make('qty')->title('Qty')->width(80),
            //Column::make('price')->title('Price')->width(100),
            //Column::make('req_price')->title('Req. Price')->width(100),

            //Column::make('status')->title('Status')->width(100),

            Column::make('created_at')->title('Date'),

            Column::computed('action')
                ->title('Action')
                ->searchable(false)
                ->orderable(false)
                ->width(110),
        ];
    }

    /**
     * Action buttons
     */
    protected function getActionColumn($data): string
    {
        $viewUrl   = route('sysadmin.enquiry.view', $data->id);
        $editUrl   = route('sysadmin.enquiry.edit', $data->id);
        $deleteUrl = route('sysadmin.enquiry.delete', $data->id);

        return '
        <ul class="action">
            <li class="view">
                <a href="' . $viewUrl . '" title="view">
                    <i class="icon-eye"></i>
                </a>
            </li>
            <li class="edit">
                <a href="' . $editUrl . '" title="edit">
                    <i class="icon-pencil-alt"></i>
                </a>
            </li>
            <li class="delete">
                <a href="' . $deleteUrl . '" title="delete">
                    <i class="icon-trash"></i>
                </a>
            </li>
        </ul>';
    }

    /**
     * Export filename
     */
    protected function filename(): string
    {
        return 'Enquiry_' . date('YmdHis');
    }
}
