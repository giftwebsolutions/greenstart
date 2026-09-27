<?php

namespace Modules\SysAdmin\Support;

use Modules\SysAdmin\Livewire\Tables\ResourceTable;

abstract class LivewireDataTable
{
    protected string $resource;

    public function render(string $view)
    {
        $definition = ResourceTable::definitions()[$this->resource];

        return view('sysadmin::tables.index', [
            'dataTable' => $this,
            'definition' => $definition,
            'resource' => $this->resource,
        ]);
    }
}
