<?php

namespace Modules\SysAdmin\Support;

use Illuminate\Support\HtmlString;
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
        ]);
    }

    public function table(array $attributes = []): HtmlString
    {
        return new HtmlString(sprintf('<livewire:sysadmin.resource-table resource="%s" />', e($this->resource)));
    }

    public function scripts(array $attributes = []): HtmlString
    {
        return new HtmlString('');
    }
}
