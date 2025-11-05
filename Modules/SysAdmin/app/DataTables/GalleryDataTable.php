<?php

namespace Modules\SysAdmin\DataTables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\SysAdmin\Models\Gallery;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GalleryDataTable extends DataTable
{
    public function query(Gallery $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'name', 'status', 'created_at']);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query = new EloquentDataTable($query);
        $query->addColumn('action', function ($data) {
            return $this->getActionColumn($data);
        })->editColumn('created_at', function ($data) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at);
        })->setRowId('id');
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('gallery-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('add')->action("window.location = '" . route('sysadmin.gallery.create') . "';"),
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
            Column::make('status'),
            Column::make('created_at')->searchable(false),
            Column::make('action')->searchable(false)->orderable(true)->width(100),
        ];
    }

    protected function getActionColumn($data): string
    {
        $showUrl = route('sysadmin.gallery.view', $data->id);
        $editUrl = route('sysadmin.gallery.edit', $data->id);
        $deleteUrl = route('sysadmin.gallery.delete', $data->id);
        return '
        <ul class="action">
            <li class="edit"> <a href="' . $editUrl . '" data-bs-original-title="edit" title="edit"><i class="icon-pencil-alt"></i></a></li>
            <li class="view"> <a href="' . $showUrl . '" data-bs-original-title="view" title="view"><i class="icon-eye"></i></a></li>
            <li class="delete"><a href="' . $deleteUrl . '" data-bs-original-title="delete" title="delete"><i class="icon-trash"></i></a></li>
        </ul>';
    }

    protected function filename(): string
    {
        return 'gallery_' . date('YmdHis');
    }
}
