<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Catalog\Families;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\SysAdmin\Models\Attribute;
use Modules\SysAdmin\Models\AttributeFamily;
use Modules\SysAdmin\Models\AttributeGroup;

class Builder extends Component
{
    public ?int $familyId = null;

    public string $name = '';

    public string $code = '';

    public int $status = 1;

    /** @var array<int, array<int, array<string, mixed>>> */
    public array $columns = [1 => [], 2 => []];

    public string $newGroupName = '';

    public string $newGroupCode = '';

    public int $newGroupColumn = 1;

    public string $attributeSearch = '';

    public ?string $selectedGroupKey = null;

    public bool $structureDirty = false;

    public function mount(?int $id = null): void
    {
        if (! $id) {
            return;
        }

        $family = AttributeFamily::findOrFail($id);
        $this->familyId = $family->id;
        $this->name = $family->name;
        $this->code = $family->code;
        $this->status = $family->status;
        $this->loadStructure();
    }

    public function updatedName(string $value): void
    {
        if (! $this->familyId || $this->code === '') {
            $this->code = Str::slug($value, '_');
        }
    }

    public function updatedNewGroupName(string $value): void
    {
        if ($this->newGroupCode === '') {
            $this->newGroupCode = Str::slug($value, '_');
        }
    }

    public function saveDetails(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'alpha_dash:ascii', 'max:64', Rule::unique('attribute_families', 'code')->ignore($this->familyId)],
            'status' => ['required', Rule::in([0, 1, 2])],
        ]);

        $family = AttributeFamily::updateOrCreate(['id' => $this->familyId], [
            'name' => trim($data['name']),
            'code' => Str::lower(trim($data['code'])),
            'status' => $data['status'],
        ]);

        if (! $this->familyId) {
            $family->groups()->create([
                'name' => 'General',
                'slug' => 'general',
                'position' => 0,
                'column' => 1,
                'is_user_defined' => false,
                'status' => 1,
            ]);
        }

        $this->familyId = $family->id;
        $this->loadStructure();
        $this->dispatch('toast', message: 'Family details saved. Build its attribute structure below.');
    }

    public function addGroup(): void
    {
        $this->ensureFamilyExists();
        $data = $this->validate([
            'newGroupName' => ['required', 'string', 'max:100'],
            'newGroupCode' => ['required', 'alpha_dash:ascii', 'max:64'],
            'newGroupColumn' => ['required', Rule::in([1, 2])],
        ], attributes: [
            'newGroupName' => 'group name',
            'newGroupCode' => 'group code',
            'newGroupColumn' => 'group column',
        ]);

        $nameExists = collect($this->columns)->flatten(1)->contains(
            fn (array $group): bool => Str::lower($group['name']) === Str::lower(trim($data['newGroupName']))
        );
        $codeExists = collect($this->columns)->flatten(1)->contains(
            fn (array $group): bool => $group['code'] === Str::lower(trim($data['newGroupCode']))
        );

        if ($nameExists || $codeExists) {
            $this->addError($nameExists ? 'newGroupName' : 'newGroupCode', 'Group names and codes must be unique within a family.');

            return;
        }

        $key = 'new_'.Str::lower(Str::random(10));
        $column = (int) $data['newGroupColumn'];
        $this->columns[$column][] = [
            'key' => $key,
            'id' => null,
            'name' => trim($data['newGroupName']),
            'code' => Str::lower(trim($data['newGroupCode'])),
            'is_user_defined' => true,
            'attributes' => [],
            'collapsed' => false,
        ];

        $this->selectedGroupKey = $key;
        $this->newGroupName = '';
        $this->newGroupCode = '';
        $this->newGroupColumn = 1;
        $this->structureDirty = true;
        $this->resetValidation(['newGroupName', 'newGroupCode', 'newGroupColumn']);
    }

    public function selectGroup(string $groupKey): void
    {
        $this->selectedGroupKey = $groupKey;
    }

    public function renameGroup(string $groupKey, string $name): void
    {
        $name = trim($name);

        if ($name === '') {
            return;
        }

        $this->mutateGroup($groupKey, function (array &$group) use ($name): void {
            $group['name'] = $name;
        });
        $this->structureDirty = true;
    }

    public function toggleGroup(string $groupKey): void
    {
        $this->mutateGroup($groupKey, function (array &$group): void {
            $group['collapsed'] = ! ($group['collapsed'] ?? false);
        });
    }

    public function moveGroup(string $groupKey, int $column, ?int $position = null): void
    {
        if (! in_array($column, [1, 2], true)) {
            return;
        }

        $group = $this->pullGroup($groupKey);

        if (! $group) {
            return;
        }

        $position = $position === null ? count($this->columns[$column]) : max(0, min($position, count($this->columns[$column])));
        array_splice($this->columns[$column], $position, 0, [$group]);
        $this->structureDirty = true;
    }

    public function nudgeGroup(string $groupKey, string $direction): void
    {
        [$column, $index] = $this->findGroup($groupKey);

        if ($column === null || $index === null) {
            return;
        }

        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if (! isset($this->columns[$column][$target])) {
            return;
        }

        [$this->columns[$column][$index], $this->columns[$column][$target]] = [$this->columns[$column][$target], $this->columns[$column][$index]];
        $this->structureDirty = true;
    }

    public function deleteSelectedGroup(): void
    {
        if (! $this->selectedGroupKey) {
            $this->addError('group', 'Select a group before deleting it.');

            return;
        }

        [$column, $index] = $this->findGroup($this->selectedGroupKey);

        if ($column === null || $index === null) {
            return;
        }

        if (! $this->columns[$column][$index]['is_user_defined']) {
            $this->addError('group', 'System groups cannot be deleted.');

            return;
        }

        array_splice($this->columns[$column], $index, 1);
        $this->selectedGroupKey = null;
        $this->structureDirty = true;
    }

    public function assignAttribute(int $attributeId, string $groupKey, ?int $position = null): void
    {
        Attribute::findOrFail($attributeId);
        $this->removeAttributeFromStructure($attributeId);

        $this->mutateGroup($groupKey, function (array &$group) use ($attributeId, $position): void {
            $position = $position === null ? count($group['attributes']) : max(0, min($position, count($group['attributes'])));
            array_splice($group['attributes'], $position, 0, [$attributeId]);
        });

        $this->structureDirty = true;
    }

    public function unassignAttribute(int $attributeId): void
    {
        $this->removeAttributeFromStructure($attributeId);
        $this->structureDirty = true;
    }

    public function nudgeAttribute(string $groupKey, int $attributeId, string $direction): void
    {
        $this->mutateGroup($groupKey, function (array &$group) use ($attributeId, $direction): void {
            $index = array_search($attributeId, $group['attributes'], true);

            if ($index === false) {
                return;
            }

            $target = $direction === 'up' ? $index - 1 : $index + 1;

            if (! isset($group['attributes'][$target])) {
                return;
            }

            [$group['attributes'][$index], $group['attributes'][$target]] = [$group['attributes'][$target], $group['attributes'][$index]];
        });

        $this->structureDirty = true;
    }

    public function saveStructure(): void
    {
        $this->ensureFamilyExists();

        DB::transaction(function (): void {
            $existingGroups = AttributeGroup::where('family_id', $this->familyId)->get()->keyBy('id');
            $previousAttributeIds = DB::table('attribute_mapping')
                ->whereIn('group_id', $existingGroups->keys())
                ->pluck('attribute_id')
                ->unique();
            $retainedGroupIds = collect();
            $newAssignments = collect();
            $globalPosition = 0;

            foreach ([1, 2] as $column) {
                foreach ($this->columns[$column] as $groupState) {
                    $group = filled($groupState['id'])
                        ? $existingGroups->get((int) $groupState['id'])
                        : new AttributeGroup(['family_id' => $this->familyId, 'is_user_defined' => true, 'status' => 1]);

                    abort_unless($group, 404);
                    $group->fill([
                        'family_id' => $this->familyId,
                        'name' => trim($groupState['name']),
                        'slug' => $groupState['code'] ?: Str::slug($groupState['name']),
                        'position' => $globalPosition++,
                        'column' => $column,
                    ])->save();

                    $retainedGroupIds->push($group->id);

                    foreach (array_values($groupState['attributes']) as $position => $attributeId) {
                        $newAssignments->push([
                            'attribute_id' => $attributeId,
                            'group_id' => $group->id,
                            'position' => $position,
                            'value' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::table('attribute_mapping')->whereIn('group_id', $existingGroups->keys())->delete();

            if ($newAssignments->isNotEmpty()) {
                DB::table('attribute_mapping')->insert($newAssignments->all());
            }

            AttributeGroup::where('family_id', $this->familyId)
                ->whereNotIn('id', $retainedGroupIds)
                ->where('is_user_defined', true)
                ->delete();

            $newAssignments->groupBy('attribute_id')->each(function ($assignments, $attributeId): void {
                Attribute::whereKey($attributeId)->update(['group_id' => $assignments->first()['group_id']]);
            });

            $removedAttributeIds = $previousAttributeIds->diff($newAssignments->pluck('attribute_id')->unique());
            foreach ($removedAttributeIds as $attributeId) {
                $replacementGroupId = DB::table('attribute_mapping')->where('attribute_id', $attributeId)->value('group_id');
                Attribute::whereKey($attributeId)->update(['group_id' => $replacementGroupId]);
            }
        });

        $this->loadStructure();
        $this->dispatch('toast', message: 'Attribute family structure saved.');
    }

    public function discardStructureChanges(): void
    {
        $this->loadStructure();
        $this->dispatch('toast', message: 'Unsaved structure changes discarded.');
    }

    public function render()
    {
        $family = $this->familyId ? AttributeFamily::findOrFail($this->familyId) : null;
        $allAttributes = Attribute::query()->with('attribute_type')->orderBy('name')->get();
        $assignedIds = collect($this->columns)->flatten(1)->flatMap(fn (array $group) => $group['attributes'])->map(fn ($id) => (int) $id)->unique();
        $availableAttributes = $allAttributes
            ->reject(fn (Attribute $attribute) => $assignedIds->contains($attribute->id))
            ->when($this->attributeSearch !== '', function ($attributes) {
                $term = Str::lower(trim($this->attributeSearch));

                return $attributes->filter(fn (Attribute $attribute) => Str::contains(Str::lower($attribute->name.' '.$attribute->code.' '.$attribute->attribute_type?->type_name), $term));
            });

        return view('sysadmin::livewire.catalog.families.builder', [
            'family' => $family,
            'availableAttributes' => $availableAttributes,
            'attributesById' => $allAttributes->keyBy('id'),
            'assignedCount' => $assignedIds->count(),
            'totalAttributeCount' => $allAttributes->count(),
        ]);
    }

    private function loadStructure(): void
    {
        $groups = AttributeGroup::query()
            ->where('family_id', $this->familyId)
            ->with('attributes:id')
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        $this->columns = [1 => [], 2 => []];

        foreach ($groups as $group) {
            $column = in_array((int) $group->column, [1, 2], true) ? (int) $group->column : 1;
            $this->columns[$column][] = [
                'key' => 'group_'.$group->id,
                'id' => $group->id,
                'name' => $group->name,
                'code' => $group->slug,
                'is_user_defined' => (bool) $group->is_user_defined,
                'attributes' => $group->attributes->pluck('id')->map(fn ($id) => (int) $id)->values()->all(),
                'collapsed' => false,
            ];
        }

        $this->selectedGroupKey = null;
        $this->structureDirty = false;
    }

    private function ensureFamilyExists(): void
    {
        if (! $this->familyId) {
            $this->saveDetails();
        }
    }

    /** @return array{0: int|null, 1: int|null} */
    private function findGroup(string $groupKey): array
    {
        foreach ([1, 2] as $column) {
            foreach ($this->columns[$column] as $index => $group) {
                if ($group['key'] === $groupKey) {
                    return [$column, $index];
                }
            }
        }

        return [null, null];
    }

    private function mutateGroup(string $groupKey, callable $callback): void
    {
        [$column, $index] = $this->findGroup($groupKey);

        if ($column === null || $index === null) {
            return;
        }

        $callback($this->columns[$column][$index]);
    }

    private function pullGroup(string $groupKey): ?array
    {
        [$column, $index] = $this->findGroup($groupKey);

        if ($column === null || $index === null) {
            return null;
        }

        return array_splice($this->columns[$column], $index, 1)[0];
    }

    private function removeAttributeFromStructure(int $attributeId): void
    {
        foreach ([1, 2] as $column) {
            foreach ($this->columns[$column] as &$group) {
                $group['attributes'] = array_values(array_filter(
                    $group['attributes'],
                    fn ($id): bool => (int) $id !== $attributeId
                ));
            }
            unset($group);
        }
    }
}
