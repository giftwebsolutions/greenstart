<?php

namespace Modules\SysAdmin\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'name', 'guard_name', 'created_at']);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', fn($data) => $this->getActionColumn($data))
            ->editColumn('created_at', fn($data) => date('d-m-Y H:i', strtotime($data->created_at)))
            ->setRowId('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('role-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->buttons([
                Button::make('add')->action("window.location = '" . route('sysadmin.roles.create') . "';"),
                Button::make('excel'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('guard_name')->title('Guard'),
            Column::make('created_at')->searchable(false),
            Column::make('action')->searchable(false)->orderable(false)->width(100),
        ];
    }

    protected function getActionColumn($data): string
    {
        $showUrl   = route('sysadmin.roles.view', $data->id);
        $editUrl   = route('sysadmin.roles.edit', $data->id);
        $deleteUrl = route('sysadmin.roles.delete', $data->id);

        return '
        <ul class="action">
            <li class="edit"><a href="' . $editUrl . '" title="edit"><i class="icon-pencil-alt"></i></a></li>
            <li class="view"><a href="' . $showUrl . '" title="view"><i class="icon-eye"></i></a></li>
            <li class="delete"><a href="' . $deleteUrl . '" title="delete"><i class="icon-trash"></i></a></li>
        </ul>';
    }

    protected function filename(): string
    {
        return 'roles_' . date('YmdHis');
    }
}
