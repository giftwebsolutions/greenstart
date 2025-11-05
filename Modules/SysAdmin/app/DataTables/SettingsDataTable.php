<?php

namespace Modules\SysAdmin\DataTables;

use Carbon\Carbon;
use Modules\SysAdmin\Models\Settings;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SettingsDataTable extends DataTable
{
    public function query(Settings $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'key', 'value', 'type']);
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
            ->setTableId('settings-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            //->selectStyleSingle()
            ->parameters([
                'dom'          => 'Bfrtip',
                'buttons'      => ['export', 'print', 'reset', 'reload'],
            ])
            ->buttons([
                Button::make('add')->attr(['id' => 'add-new', 'data-title' => 'Add New Settings', 'data-url' => route('sysadmin.settings.ajax-form')])->action('javascript:void(0);'),
                Button::make('excel'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('key'),
            Column::make('value'),
            Column::make('action')->searchable(false)->orderable(true)->width(100),
        ];
    }

    protected function getActionColumn($data): string
    {
        $showUrl = route('sysadmin.settings.ajax-view', $data->id);
        $editUrl = route('sysadmin.settings.ajax-form', ['id' => $data->id]);
        $deleteUrl = route('sysadmin.settings.delete', $data->id);
        return '
        <ul class="action">
            <li class="edit"> <a href="javascript:void(0)" id="ajax-edit" data-title="Settings View" data-url="' . $editUrl . '" data-bs-original-title="edit" title="edit"><i class="icon-pencil-alt"></i></a></li>
            <li class="view"> <a href="javascript:void(0)" id="ajax-view" data-title="Settings View" data-url="' . $showUrl . '" data-bs-original-title="view" title="view"><i class="icon-eye"></i></a></li>
            <li class="delete"><a href="' . $deleteUrl . '" data-bs-original-title="delete" title="delete"><i class="icon-trash"></i></a></li>
        </ul>';
    }

    protected function filename(): string
    {
        return 'settings_' . date('YmdHis');
    }
}
