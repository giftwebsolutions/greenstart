<?php

namespace Modules\SysAdmin\Livewire\Catalog\Families;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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

    public string $newGroupName = '';

    public string $attributeSearch = '';

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
    }

    public function updatedName(string $value): void
    {
        if (! $this->familyId || $this->code === '') {
            $this->code = Str::slug($value, '_');
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
                'is_user_defined' => false,
                'status' => 1,
            ]);
        }

        $this->familyId = $family->id;
        $this->dispatch('toast', message: 'Family details saved.');
    }

    public function addGroup(): void
    {
        $this->ensureFamilyExists();
        $this->validate([
            'newGroupName' => [
                'required',
                'string',
                'max:100',
                Rule::unique('attribute_group', 'name')->where('family_id', $this->familyId),
            ],
        ], attributes: ['newGroupName' => 'group name']);

        $position = (int) AttributeGroup::where('family_id', $this->familyId)->max('position') + 1;
        AttributeGroup::create([
            'family_id' => $this->familyId,
            'name' => trim($this->newGroupName),
            'slug' => Str::slug($this->newGroupName),
            'position' => $position,
            'is_user_defined' => true,
            'status' => 1,
        ]);

        $this->newGroupName = '';
        $this->resetValidation('newGroupName');
    }

    public function renameGroup(int $groupId, string $name): void
    {
        $group = $this->group($groupId);
        $name = trim($name);

        if ($name === '') {
            return;
        }

        if (AttributeGroup::where('family_id', $this->familyId)->where('name', $name)->where('id', '!=', $groupId)->exists()) {
            throw ValidationException::withMessages(['group' => 'Group names must be unique within a family.']);
        }

        $group->update(['name' => $name, 'slug' => Str::slug($name)]);
    }

    public function deleteGroup(int $groupId): void
    {
        $group = $this->group($groupId);

        if (! $group->is_user_defined) {
            $this->addError('group', 'The system General group cannot be deleted.');

            return;
        }

        DB::transaction(function () use ($group): void {
            $general = AttributeGroup::where('family_id', $this->familyId)->orderBy('position')->firstOrFail();
            $nextPosition = (int) $general->attributes()->max('attribute_mapping.position') + 1;

            foreach ($group->attributes as $attribute) {
                $general->attributes()->syncWithoutDetaching([
                    $attribute->id => ['position' => $nextPosition++, 'value' => $attribute->pivot->value],
                ]);
            }

            $group->delete();
            $this->normalizeGroupPositions();
        });
    }

    public function moveGroup(int $groupId, string $direction): void
    {
        $groups = AttributeGroup::where('family_id', $this->familyId)->orderBy('position')->orderBy('id')->get();
        $index = $groups->search(fn ($group) => $group->id === $groupId);
        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if ($index === false || ! isset($groups[$target])) {
            return;
        }

        $ordered = $groups->values()->all();
        [$ordered[$index], $ordered[$target]] = [$ordered[$target], $ordered[$index]];
        foreach ($ordered as $position => $group) {
            $group->update(['position' => $position]);
        }
    }

    public function assignAttribute(int $attributeId, int $groupId): void
    {
        $group = $this->group($groupId);
        Attribute::findOrFail($attributeId);

        DB::transaction(function () use ($attributeId, $group): void {
            $familyGroupIds = AttributeGroup::where('family_id', $this->familyId)->pluck('id');
            DB::table('attribute_mapping')
                ->where('attribute_id', $attributeId)
                ->whereIn('group_id', $familyGroupIds)
                ->delete();

            $position = (int) $group->attributes()->max('attribute_mapping.position') + 1;
            $group->attributes()->attach($attributeId, ['position' => $position]);

            Attribute::whereKey($attributeId)->update(['group_id' => $group->id]);
        });
    }

    public function unassignAttribute(int $attributeId): void
    {
        $familyGroupIds = AttributeGroup::where('family_id', $this->familyId)->pluck('id');
        DB::table('attribute_mapping')->where('attribute_id', $attributeId)->whereIn('group_id', $familyGroupIds)->delete();
        $replacementGroupId = DB::table('attribute_mapping')->where('attribute_id', $attributeId)->value('group_id');
        Attribute::whereKey($attributeId)->update(['group_id' => $replacementGroupId]);
    }

    public function moveAttribute(int $groupId, int $attributeId, string $direction): void
    {
        $group = $this->group($groupId);
        $attributes = $group->attributes()->get();
        $index = $attributes->search(fn ($attribute) => $attribute->id === $attributeId);
        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if ($index === false || ! isset($attributes[$target])) {
            return;
        }

        $ordered = $attributes->values()->all();
        [$ordered[$index], $ordered[$target]] = [$ordered[$target], $ordered[$index]];
        foreach ($ordered as $position => $attribute) {
            DB::table('attribute_mapping')
                ->where('group_id', $groupId)
                ->where('attribute_id', $attribute->id)
                ->update(['position' => $position]);
        }
    }

    private function group(int $groupId): AttributeGroup
    {
        return AttributeGroup::where('family_id', $this->familyId)->findOrFail($groupId);
    }

    private function ensureFamilyExists(): void
    {
        if (! $this->familyId) {
            $this->saveDetails();
        }
    }

    private function normalizeGroupPositions(): void
    {
        AttributeGroup::where('family_id', $this->familyId)->orderBy('position')->orderBy('id')->get()
            ->each(fn ($group, $position) => $group->update(['position' => $position]));
    }

    public function render()
    {
        $family = $this->familyId
            ? AttributeFamily::with(['groups.attributes.attribute_type'])->findOrFail($this->familyId)
            : null;

        $assignedIds = $family?->groups->flatMap->attributes->pluck('id')->unique() ?? collect();
        $availableAttributes = Attribute::query()
            ->with('attribute_type')
            ->when($this->attributeSearch !== '', function ($query): void {
                $term = '%'.trim($this->attributeSearch).'%';
                $query->where(fn ($nested) => $nested->where('name', 'like', $term)->orWhere('code', 'like', $term));
            })
            ->whereNotIn('id', $assignedIds)
            ->orderBy('name')
            ->limit(100)
            ->get();

        return view('sysadmin::livewire.catalog.families.builder', compact('family', 'availableAttributes'));
    }
}
