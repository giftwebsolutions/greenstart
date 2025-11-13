<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\SysAdmin\DataTables\AttributeGroupDataTable;
use Modules\SysAdmin\Interfaces\AttributeGroupInterface;
use Modules\SysAdmin\Models\Attribute;
use Modules\SysAdmin\Models\AttributeGroup;
use Modules\SysAdmin\Requests\AttributeGroupFormRequest;

class AttributeGroupController extends Controller
{
    public function __construct(
        protected AttributeGroupInterface $groupRepository
    ) {}

    public function index(AttributeGroupDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.groups.index');
    }

    public function create()
    {
        // Load attributes (filter to active/draft if you want)
        $attributes = Attribute::orderBy('name')->get(['id', 'name']);

        return view('sysadmin::catalog.groups.create', [
            'statuses'   => $this->groupRepository->getStatuses(),
            'attributes' => $attributes,
        ]);
    }

    public function store(AttributeGroupFormRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // create group via repository
        /** @var AttributeGroup $group */
        $group = $this->groupRepository->saveOrUpdate($data);

        // sync attribute mappings
        $this->syncAttributes($group, $request);

        return redirect()
            ->route('sysadmin.catalog.attribute.group.index')
            ->with('success', 'Attribute group created successfully.');
    }

    public function edit(int $id)
    {
        /** @var AttributeGroup $group */
        $group = $this->groupRepository->find($id);

        // eager-load current mappings for the form
        $group->load(['attributes' => function ($q) {
            $q->select('attribute.id', 'attribute.name');
        }]);

        $attributes = Attribute::orderBy('name')->get(['id', 'name']);

        return view('sysadmin::catalog.groups.edit', [
            'group'      => $group,
            'statuses'   => $this->groupRepository->getStatuses(),
            'attributes' => $attributes,
        ]);
    }

    public function update(AttributeGroupFormRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        /** @var AttributeGroup $group */
        $group = $this->groupRepository->saveOrUpdate($data, $id);

        // sync attribute mappings
        $this->syncAttributes($group, $request);

        return redirect()
            ->route('sysadmin.catalog.attribute.group.index')
            ->with('success', 'Attribute group updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->groupRepository->delete($id);

        return redirect()
            ->route('sysadmin.catalog.attribute.group.index')
            ->with('success', 'Attribute group deleted successfully.');
    }

    /**
     * Build and sync pivot payload to attribute_group_map
     *
     * Expects:
     *  - attributes[]            : array of attribute IDs
     *  - attribute_values[id]    : optional per-attribute value
     */
    protected function syncAttributes(AttributeGroup $group, Request $request): void
    {
        $ids    = collect($request->input('attributes', []))
            ->map(fn($v) => (int) $v)
            ->filter()
            ->values();

        $values = $request->input('attribute_values', []); // [attribute_id => value]

        // Build [attribute_id => ['value' => '...']]
        $syncPayload = $ids->mapWithKeys(function ($attrId) use ($values) {
            return [$attrId => ['value' => $values[$attrId] ?? null]];
        })->toArray();

        // Ensure the relation exists on the model:
        // AttributeGroup::attributes() -> belongsToMany(Attribute::class, 'attribute_group_map', 'group_id', 'attribute_id')
        $group->attributes()->sync($syncPayload);
        // If you prefer additive updates: $group->attributes()->syncWithoutDetaching($syncPayload);
    }

    public function show(int $id)
    {
        $group = AttributeGroup::with(['attributes' => function ($q) {
            $q->select('attribute.id', 'attribute.name');
        }])->withCount('attributes')->findOrFail($id);

        return view('sysadmin::catalog.groups.view', [
            'group'    => $group,
            'statuses' => $this->groupRepository->getStatuses(),
        ]);
    }
}
