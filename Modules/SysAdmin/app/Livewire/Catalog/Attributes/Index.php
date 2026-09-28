<?php

namespace Modules\SysAdmin\Livewire\Catalog\Attributes;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\SysAdmin\Models\Attribute;
use Modules\SysAdmin\Models\AttributeFamily;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: 'all')]
    public string $status = 'all';

    #[Url(except: 'all')]
    public string $family = 'all';

    #[Url(except: 'all')]
    public string $usage = 'all';

    public string $sortBy = 'sort_order';

    public string $sortDirection = 'asc';

    public int $perPage = 15;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFamily(): void
    {
        $this->resetPage();
    }

    public function updatedUsage(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        abort_unless(in_array($column, ['name', 'code', 'sort_order', 'status'], true), 422);

        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function delete(int $id): void
    {
        $attribute = Attribute::withCount(['values', 'mappings'])->findOrFail($id);

        if ($attribute->values()->whereHas('variantValues')->exists()) {
            $this->addError('delete', 'This attribute has values used by product variants and cannot be deleted.');

            return;
        }

        $attribute->delete();
        session()->flash('success', 'Attribute deleted successfully.');
        $this->resetPage();
    }

    public function render()
    {
        $attributeRows = Attribute::query()
            ->with(['attribute_type:attribute_type_id,type_name,identifier', 'groups.family:id,name'])
            ->when($this->search !== '', function ($query): void {
                $term = '%'.trim($this->search).'%';
                $query->where(fn ($nested) => $nested->where('name', 'like', $term)->orWhere('code', 'like', $term));
            })
            ->when($this->status !== 'all', fn ($query) => $query->where('status', (int) $this->status))
            ->when($this->family !== 'all', fn ($query) => $query->whereHas('groups', fn ($groupQuery) => $groupQuery->where('family_id', (int) $this->family)))
            ->when($this->usage !== 'all', fn ($query) => $query->where($this->usage, true))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->orderBy('id')
            ->paginate($this->perPage);

        return view('sysadmin::livewire.catalog.attributes.index', [
            'attributeRows' => $attributeRows,
            'families' => AttributeFamily::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
