<?php

namespace Modules\SysAdmin\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\SysAdmin\Models\Testimonial;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class TestimonialDataTable extends DataTable
{
    public function query(Testimonial $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'name', 'content', 'updated_at']);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->editColumn('content', function ($data) {
                return Str::limit(strip_tags($data->content), 60);
            })
            ->editColumn('updated_at', function ($data) {
                return optional($data->updated_at)->format('d-m-Y H:i');
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('testimonial-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->processing(true)   // ✅ REQUIRED
            ->serverSide(true)   // ✅ REQUIRED
            ->orderBy(0)
            ->buttons([
                Button::make('create')
                    ->action("window.location = '" . route('sysadmin.testimonial.create') . "';"),
                Button::make('excel'),
                Button::make('reload'),
            ]);
    }

    protected function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('name')->title('Name'),
            Column::make('content')
                ->title('Content')
                ->orderable(false)
                ->searchable(true),
            Column::make('updated_at')
                ->title('Updated At')
                ->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function getActionColumn($data): string
    {
        return '
        <ul class="action">
            <li class="edit">
                <a href="' . route('sysadmin.testimonial.edit', $data->id) . '">
                    <i class="icon-pencil-alt"></i>
                </a>
            </li>
            <li class="view">
                <a href="' . route('sysadmin.testimonial.view', $data->id) . '">
                    <i class="icon-eye"></i>
                </a>
            </li>
            <li class="delete">
                <a href="' . route('sysadmin.testimonial.delete', $data->id) . '">
                    <i class="icon-trash"></i>
                </a>
            </li>
        </ul>';
    }

    protected function filename(): string
    {
        return 'Testimonials_' . date('YmdHis');
    }
}
