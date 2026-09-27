<?php

namespace Modules\SysAdmin\Livewire\Catalog\Attributes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\SysAdmin\Models\Attribute;
use Modules\SysAdmin\Models\AttributeType;
use Modules\SysAdmin\Models\AttributeValue;

class Form extends Component
{
    public ?int $attributeId = null;

    public string $name = '';

    public string $code = '';

    public string $type = '';

    public int $sortOrder = 0;

    public bool $isRequired = false;

    public bool $isFilterable = false;

    public bool $isConfigurable = false;

    public bool $isComparable = false;

    public int $status = 1;

    public array $values = [['id' => null, 'value' => '']];

    public function mount(?int $id = null): void
    {
        if (! $id) {
            return;
        }

        $attribute = Attribute::with(['values' => fn ($query) => $query->orderBy('sort_order')])->findOrFail($id);
        $this->attributeId = $attribute->id;
        $this->name = $attribute->name;
        $this->code = (string) $attribute->code;
        $this->type = (string) $attribute->type;
        $this->sortOrder = (int) $attribute->sort_order;
        $this->isRequired = (bool) $attribute->require;
        $this->isFilterable = (bool) $attribute->filterable;
        $this->isConfigurable = (bool) $attribute->configurable;
        $this->isComparable = (bool) $attribute->comparable;
        $this->status = (int) $attribute->status;
        $this->values = $attribute->values->map(fn ($value) => ['id' => $value->id, 'value' => $value->value])->values()->all();
        $this->values = $this->values ?: [['id' => null, 'value' => '']];
    }

    public function updatedName(string $value): void
    {
        if (! $this->attributeId || $this->code === '') {
            $this->code = Str::slug($value, '_');
        }
    }

    public function addValue(): void
    {
        $this->values[] = ['id' => null, 'value' => ''];
    }

    public function removeValue(int $index): void
    {
        unset($this->values[$index]);
        $this->values = array_values($this->values) ?: [['id' => null, 'value' => '']];
    }

    public function moveValue(int $index, string $direction): void
    {
        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if (! isset($this->values[$index], $this->values[$target])) {
            return;
        }

        [$this->values[$index], $this->values[$target]] = [$this->values[$target], $this->values[$index]];
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'alpha_dash:ascii', 'max:64', Rule::unique('attribute', 'code')->ignore($this->attributeId)],
            'type' => ['required', 'integer', Rule::exists('attribute_type', 'attribute_type_id')],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:65535'],
            'isRequired' => ['boolean'],
            'isFilterable' => ['boolean'],
            'isConfigurable' => ['boolean'],
            'isComparable' => ['boolean'],
            'status' => ['required', Rule::in([0, 1, 2])],
            'values' => ['array'],
            'values.*.id' => ['nullable', 'integer'],
            'values.*.value' => ['nullable', 'string', 'max:255'],
        ], attributes: [
            'sortOrder' => 'sort order',
            'isRequired' => 'required',
            'isFilterable' => 'filterable',
            'isConfigurable' => 'configurable',
            'isComparable' => 'comparable',
        ]);

        $type = AttributeType::findOrFail((int) $data['type']);
        $identifier = $this->normalizeIdentifier($type->identifier);
        $usesOptions = in_array($identifier, ['select', 'multiselect'], true);

        if ($this->isConfigurable && $identifier !== 'select') {
            $this->addError('isConfigurable', 'Only a single-select (dropdown / enum) attribute can generate product variants.');

            return;
        }

        $optionRows = collect($data['values'])
            ->map(fn (array $row) => ['id' => $row['id'] ?? null, 'value' => trim((string) ($row['value'] ?? ''))])
            ->filter(fn (array $row) => $row['value'] !== '')
            ->values();

        if ($usesOptions && $optionRows->isEmpty()) {
            $this->addError('values', 'Add at least one option for this attribute type.');

            return;
        }

        $creating = $this->attributeId === null;

        DB::transaction(function () use ($data, $optionRows, $usesOptions): void {
            $payload = [
                'name' => trim($data['name']),
                'code' => Str::lower(trim($data['code'])),
                'sort_order' => $data['sortOrder'],
                'type' => (int) $data['type'],
                'require' => $data['isRequired'],
                'filterable' => $data['isFilterable'],
                'configurable' => $data['isConfigurable'],
                'comparable' => $data['isComparable'],
                'status' => $data['status'],
            ];

            // Family/group assignment belongs exclusively to the family builder.
            // Do not disturb existing mappings while editing the attribute itself.
            if ($this->attributeId === null) {
                $payload['group_id'] = null;
            }

            $attribute = Attribute::updateOrCreate(['id' => $this->attributeId], $payload);

            if (! $usesOptions) {
                $attribute->values()->whereDoesntHave('variantValues')->delete();
            } else {
                $keptIds = [];

                foreach ($optionRows as $position => $row) {
                    $option = $row['id']
                        ? $attribute->values()->findOrFail($row['id'])
                        : new AttributeValue(['attribute_id' => $attribute->id]);
                    $option->value = $row['value'];
                    $option->sort_order = $position;
                    $option->save();
                    $keptIds[] = $option->id;
                }

                $attribute->values()->whereNotIn('id', $keptIds)->whereDoesntHave('variantValues')->delete();
            }

            $this->attributeId = $attribute->id;
        });

        session()->flash('success', $creating ? 'Attribute created successfully.' : 'Attribute saved successfully.');
        $this->redirectRoute('sysadmin.catalog.attribute.index', navigate: false);
    }

    public function render()
    {
        $selectedType = AttributeType::find($this->type);
        $identifier = $this->normalizeIdentifier($selectedType?->identifier);

        return view('sysadmin::livewire.catalog.attributes.form', [
            'types' => AttributeType::query()->where('status', 1)->orderBy('type_name')->get(),
            'selectedIdentifier' => $identifier,
            'usesOptions' => in_array($identifier, ['select', 'multiselect'], true),
            'canBeConfigurable' => $identifier === 'select',
        ]);
    }

    private function normalizeIdentifier(?string $identifier): string
    {
        return (string) Str::of($identifier ?? '')
            ->lower()
            ->replace(['-', ' '], '_')
            ->replaceMatches('/_+/', '_')
            ->replace('multi_select', 'multiselect');
    }
}
