<form wire:submit="save" class="grid gap-4" novalidate>
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.catalog.attribute.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">
                {!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!}
                Attributes
            </a>
            <h1 class="mt-1.5 text-xl font-bold tracking-tight text-ink">{{ $attributeId ? 'Edit attribute' : 'Create attribute' }}</h1>
            <p class="mt-0.5 max-w-2xl text-xs leading-relaxed text-ink-muted">Define one reusable product field. Group and family placement is managed after the attribute is saved.</p>
        </div>

        <div class="flex items-center gap-2">
            <x-sysadmin::btn :href="route('sysadmin.catalog.attribute.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save">Save attribute</span>
                <span wire:loading wire:target="save">Saving…</span>
            </x-sysadmin::btn>
        </div>
    </div>

    <div class="grid items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
        <div class="grid min-w-0 content-start gap-4">
            <x-sysadmin::card>
                <div class="flex flex-wrap items-start justify-between gap-2 border-b border-hairline px-4 py-3">
                    <div>
                        <h2 class="text-sm font-bold text-ink">Attribute definition</h2>
                        <p class="mt-0.5 text-[11.5px] text-ink-muted">Name the field and choose how editors enter its value.</p>
                    </div>
                    <span class="rounded-md bg-slate-100 px-2 py-1 text-[10px] font-semibold uppercase tracking-wide text-ink-muted">Catalog field</span>
                </div>

                <div class="grid gap-x-3 gap-y-3.5 p-4 md:grid-cols-12">
                    <x-sysadmin::input
                        label="Attribute label"
                        name="name"
                        wire:model.live.blur="name"
                        placeholder="e.g. Membrane size"
                        wrapper-class="md:col-span-7"
                        size="sm"
                        required
                        autofocus
                    />

                    <x-sysadmin::input
                        label="Attribute code"
                        name="code"
                        wire:model="code"
                        placeholder="membrane_size"
                        hint="Used by imports and APIs. Keep it stable."
                        wrapper-class="md:col-span-5"
                        class="font-mono"
                        size="sm"
                        required
                    />

                    <div class="md:col-span-12 mt-0.5 border-t border-hairline pt-3.5">
                        <h3 class="text-xs font-bold text-ink">Input configuration</h3>
                    </div>

                    <x-sysadmin::select
                        label="Catalog input type"
                        name="type"
                        wire:model.live="type"
                        placeholder="Choose input type"
                        wrapper-class="md:col-span-8"
                        size="sm"
                        required
                    >
                        @foreach($types as $typeOption)
                            <option value="{{ $typeOption->attribute_type_id }}">{{ $typeOption->type_name }}</option>
                        @endforeach
                    </x-sysadmin::select>

                    <x-sysadmin::input
                        label="Default position"
                        name="sortOrder"
                        type="number"
                        min="0"
                        wire:model="sortOrder"
                        wrapper-class="md:col-span-4"
                        size="sm"
                    />

                    @if($selectedIdentifier)
                        <div class="md:col-span-12 flex items-start gap-2.5 rounded-lg border border-blue-100 bg-blue-50/70 px-3 py-2.5 text-[11.5px] leading-relaxed text-blue-800">
                            <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-md bg-white text-blue-600">{!! \Modules\SysAdmin\Support\Icon::get('info', 'h-3.5 w-3.5') !!}</span>
                            <p>
                                @switch($selectedIdentifier)
                                    @case('text') A compact, single-line field for model names, materials and short specifications. @break
                                    @case('textarea') A multi-line field for longer technical or descriptive values. @break
                                    @case('select') A single-choice dropdown (enum) that supports options, filters and product variants. @break
                                    @case('multiselect') A multiple-choice option field that supports filters but not variant generation. @break
                                    @case('boolean') A simple Yes / No selector. @break
                                    @case('date') A calendar date selector. @break
                                    @case('datetime') A date and time selector. @break
                                    @case('number') A numeric field with decimal support. @break
                                    @case('price') A currency-style numeric field. @break
                                @endswitch
                            </p>
                        </div>
                    @endif
                </div>
            </x-sysadmin::card>

            @if($usesOptions)
                <x-sysadmin::card>
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-4 py-3">
                        <div>
                            <h2 class="text-sm font-bold text-ink">Attribute options</h2>
                            <p class="mt-0.5 text-[11.5px] text-ink-muted">The order below is used in product forms and storefront filters.</p>
                        </div>
                        <x-sysadmin::btn wire:click="addValue" class="min-h-9 px-3 text-xs">
                            {!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-3.5 w-3.5') !!}
                            Add option
                        </x-sysadmin::btn>
                    </div>

                    <div class="grid gap-2 p-4">
                        @error('values')
                            <p class="rounded-lg bg-red-50 px-3 py-2 text-xs text-red-700">{{ $message }}</p>
                        @enderror

                        @foreach($values as $index => $value)
                            <div class="grid grid-cols-[24px_minmax(0,1fr)] items-center gap-x-2 gap-y-1.5 rounded-lg border border-hairline bg-[#fafbfc] p-2 sm:grid-cols-[24px_minmax(0,1fr)_auto]" wire:key="option-{{ $index }}-{{ $value['id'] ?? 'new' }}">
                                <span class="grid size-6 place-items-center text-xs text-ink-muted" aria-hidden="true">⋮⋮</span>
                                <div>
                                    <input
                                        wire:model="values.{{ $index }}.value"
                                        class="min-h-9 w-full rounded-lg border bg-white px-2.5 text-[12.5px] text-ink placeholder:text-ink-muted focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $errors->has('values.'.$index.'.value') ? 'border-red-500' : 'border-hairline-strong' }}"
                                        placeholder="Option label"
                                        aria-label="Option {{ $index + 1 }} label"
                                    >
                                    @error('values.'.$index.'.value')<p class="mt-1 text-[11px] font-medium text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="col-start-2 flex items-center justify-end gap-1 sm:col-start-auto">
                                    <button type="button" wire:click="moveValue({{ $index }}, 'up')" class="grid size-8 place-items-center rounded-md border border-hairline bg-white text-sm text-ink-soft transition hover:border-primary/30 hover:text-primary disabled:cursor-not-allowed disabled:opacity-35" aria-label="Move option up" title="Move up" @disabled($loop->first)>↑</button>
                                    <button type="button" wire:click="moveValue({{ $index }}, 'down')" class="grid size-8 place-items-center rounded-md border border-hairline bg-white text-sm text-ink-soft transition hover:border-primary/30 hover:text-primary disabled:cursor-not-allowed disabled:opacity-35" aria-label="Move option down" title="Move down" @disabled($loop->last)>↓</button>
                                    <button type="button" wire:click="removeValue({{ $index }})" class="grid size-8 place-items-center rounded-md border border-red-100 bg-white text-base text-red-600 transition hover:bg-red-50" aria-label="Remove option" title="Remove">×</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-sysadmin::card>
            @endif

            <div class="flex items-start gap-2.5 rounded-xl border border-primary/15 bg-primary-50 p-3">
                <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-white text-primary">{!! \Modules\SysAdmin\Support\Icon::get('layers', 'h-4 w-4') !!}</span>
                <div>
                    <strong class="text-xs text-ink">Family mapping is managed separately</strong>
                    <p class="mt-0.5 text-[11px] leading-relaxed text-ink-muted">After saving, open an attribute family and drag this field from Unassigned attributes into the required group and form column.</p>
                </div>
            </div>
        </div>

        <aside class="min-w-0">
            <x-sysadmin::card class="sticky top-24">
                <div class="border-b border-hairline px-4 py-3">
                    <h2 class="text-sm font-bold text-ink">Behavior</h2>
                    <p class="mt-0.5 text-[11.5px] text-ink-muted">Validation and catalog capabilities.</p>
                </div>

                <div class="divide-y divide-hairline px-4">
                    @foreach([['isRequired','Required','Editors must provide a value.'],['isFilterable','Filterable','Available in catalog filters.'],['isComparable','Comparable','Shown in product comparison.']] as [$model,$label,$help])
                        <label class="flex cursor-pointer items-center justify-between gap-3 py-3">
                            <span>
                                <strong class="block text-xs text-ink">{{ $label }}</strong>
                                <small class="mt-0.5 block text-[10.5px] leading-relaxed text-ink-muted">{{ $help }}</small>
                            </span>
                            <input type="checkbox" wire:model="{{ $model }}" class="peer sr-only">
                            <span class="relative h-5 w-9 shrink-0 rounded-full bg-slate-200 transition peer-focus-visible:ring-2 peer-focus-visible:ring-primary-200 peer-checked:bg-primary after:absolute after:left-0.5 after:top-0.5 after:size-4 after:rounded-full after:bg-white after:shadow-sm after:transition peer-checked:after:translate-x-4"></span>
                        </label>
                    @endforeach

                    <label class="flex items-center justify-between gap-3 py-3 {{ $canBeConfigurable ? 'cursor-pointer' : 'cursor-not-allowed opacity-55' }}">
                        <span>
                            <strong class="block text-xs text-ink">Configurable</strong>
                            <small class="mt-0.5 block text-[10.5px] leading-relaxed text-ink-muted">Generate variants from a dropdown.</small>
                        </span>
                        <input type="checkbox" wire:model="isConfigurable" class="peer sr-only" @disabled(! $canBeConfigurable)>
                        <span class="relative h-5 w-9 shrink-0 rounded-full bg-slate-200 transition peer-focus-visible:ring-2 peer-focus-visible:ring-primary-200 peer-checked:bg-primary after:absolute after:left-0.5 after:top-0.5 after:size-4 after:rounded-full after:bg-white after:shadow-sm after:transition peer-checked:after:translate-x-4"></span>
                    </label>

                    @error('isConfigurable')<p class="pb-3 text-[11px] font-medium text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="border-t border-hairline p-4">
                    <x-sysadmin::select label="Status" name="status" wire:model="status" size="sm">
                        <option value="1">Published</option>
                        <option value="2">Draft</option>
                        <option value="0">Disabled</option>
                    </x-sysadmin::select>
                </div>
            </x-sysadmin::card>
        </aside>
    </div>
</form>
