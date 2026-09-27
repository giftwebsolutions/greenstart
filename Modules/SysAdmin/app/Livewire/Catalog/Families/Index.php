<?php

namespace Modules\SysAdmin\Livewire\Catalog\Families;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\SysAdmin\Models\AttributeFamily;

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: 'all')]
    public string $status = 'all';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $family = AttributeFamily::withCount('products')->findOrFail($id);

        if ($family->products_count > 0) {
            $this->addError('delete', 'This family is assigned to products. Reassign those products before deleting it.');

            return;
        }

        $family->delete();
        session()->flash('success', 'Attribute family deleted successfully.');
    }

    public function render()
    {
        $families = AttributeFamily::query()
            ->withCount(['groups', 'products'])
            ->withCount(['groups as attributes_count' => fn ($query) => $query
                ->join('attribute_mapping', 'attribute_group.id', '=', 'attribute_mapping.group_id')
                ->selectRaw('count(distinct attribute_mapping.attribute_id)')])
            ->when($this->search !== '', function ($query): void {
                $term = '%'.trim($this->search).'%';
                $query->where(fn ($nested) => $nested->where('name', 'like', $term)->orWhere('code', 'like', $term));
            })
            ->when($this->status !== 'all', fn ($query) => $query->where('status', (int) $this->status))
            ->orderBy('name')
            ->paginate(15);

        return view('sysadmin::livewire.catalog.families.index', compact('families'));
    }
}
