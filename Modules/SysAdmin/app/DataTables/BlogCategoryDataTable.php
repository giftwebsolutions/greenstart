<?php

namespace Modules\SysAdmin\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\SysAdmin\Models\BlogCategory;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogCategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('parent', fn ($row) => $row->parent?->name ?? '—')
            ->editColumn('status', fn ($row) =>$this->renderStatus($row->status))
            ->editColumn('updated_at', fn ($row) => $row->updated_at?->format('d-m-Y H:i'))
            ->addColumn('action', fn ($row) => $this->getActionColumn($row))
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     */
    public function query(BlogCategory $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'name', 'parent_id', 'status', 'updated_at'])
            ->with('parent');
    }

    /**
     * Optional HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('blog-category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters([
                'dom' => 'Bfrtip',
            ])
            ->buttons([
                Button::make('add')
                    ->text('<i class="bi bi-plus"></i> Add Category')
                    ->addClass('btn btn-primary')
                    ->action("window.location = '" . route('sysadmin.blog.category.create') . "';"),
                Button::make('excel'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->width(60),
            Column::make('name')->title('Name'),
            Column::make('parent')->title('Parent Category'),
            Column::make('status')->title('Status')->width(120),
            Column::make('updated_at')->title('Last Updated')->width(160),
            Column::computed('action')
                ->title('Actions')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    /**
     * Render status badge.
     */
    protected function renderStatus($status): string
    {
        return match ((int) $status) {
            1       => '<span class="badge bg-success">Active</span>',
            0       => '<span class="badge bg-danger">Inactive</span>',
            2 => '<span class="badge bg-secondary">Draft</span>',
        };
    }

    /**
     * Action buttons.
     */
    protected function getActionColumn($row): string
    {
        $showUrl   = route('sysadmin.blog.category.view', $row->id);
        $editUrl   = route('sysadmin.blog.category.edit', $row->id);
        $deleteUrl = route('sysadmin.blog.category.delete', $row->id);

        return '
            <ul class="action">
                <li class="edit">
                    <a href="' . $editUrl . '" title="Edit"><i class="icon-pencil-alt"></i></a>
                </li>
                <li class="view">
                    <a href="' . $showUrl . '" title="View"><i class="icon-eye"></i></a>
                </li>
                <li class="delete">
                    <a href="' . $deleteUrl . '" title="Delete"><i class="icon-trash"></i></a>
                </li>
            </ul>';
    }

    /**
     * File name for export.
     */
    protected function filename(): string
    {
        return 'Blog_Category_' . now()->format('YmdHis');
    }
}
