<form wire:submit="save" class="grid gap-5" novalidate>
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.catalog.product.edit', $product->id) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Product setup</a>
            <h1 class="mt-2 text-[22px] font-bold tracking-tight text-ink">Product attributes</h1>
            <p class="mt-1 text-[13px] text-ink-muted">{{ $product->title }} · {{ $family->name }}</p>
        </div>
        <div class="flex gap-2">
            <x-sysadmin::btn :href="route('sysadmin.catalog.product.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled"><span wire:loading.remove wire:target="save">Save attributes & variants</span><span wire:loading wire:target="save">Saving…</span></x-sysadmin::btn>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13px] text-red-700"><strong>Some catalog values need attention.</strong><p class="mt-1 text-xs">Review the highlighted fields below and save again.</p></div>
    @endif

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
        <div class="grid content-start gap-5">
            <section class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm">
                <header class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4">
                    <div><h2 class="text-base font-bold text-ink">{{ $family->name }} fields</h2><p class="mt-1 text-xs text-ink-muted">The field layout follows the columns, groups and order from the family builder.</p></div>
                    <span class="rounded-full bg-primary-50 px-3 py-1.5 text-[11px] font-semibold text-primary">{{ $family->groups->sum(fn ($group) => $group->attributes->count()) }} fields</span>
                </header>

                <div class="grid items-start gap-4 bg-[#fafbfc] p-4 2xl:grid-cols-2">
                    @foreach([1 => 'Main column', 2 => 'Right column'] as $column => $columnName)
                        <div class="grid content-start gap-4">
                            <div class="flex items-center justify-between px-1"><h3 class="text-[11px] font-bold uppercase tracking-[.12em] text-ink-muted">{{ $columnName }}</h3><span class="text-[10px] text-ink-muted">{{ $family->groups->where('column', $column)->count() }} groups</span></div>
                            @forelse($family->groups->where('column', $column) as $group)
                                <fieldset class="rounded-xl border border-hairline bg-white p-4 shadow-sm">
                                    <legend class="px-1 text-[13px] font-bold text-ink">{{ $group->name }}</legend>
                                    <div class="mt-2 grid gap-4">
                                        @forelse($group->attributes as $attribute)
                                            @php
                                                $identifier = (string) \Illuminate\Support\Str::of($attribute->attribute_type?->identifier ?? 'text')->lower()->replace(['-', ' '], '_')->replaceMatches('/_+/', '_')->replace('multi_select', 'multiselect');
                                                $field = 'attributeValues.'.$attribute->id;
                                                $canConfigure = (bool) $attribute->configurable && $identifier === 'select';
                                            @endphp
                                            <div wire:key="product-attribute-{{ $attribute->id }}">
                                                <div class="mb-1.5 flex items-center justify-between gap-3">
                                                    <label class="text-[12.5px] font-bold text-ink" for="attribute-{{ $attribute->id }}">{{ $attribute->name }} @if($attribute->require)<span class="text-red-600">*</span>@endif</label>
                                                    <code class="text-[9.5px] text-ink-muted">{{ $attribute->code }}</code>
                                                </div>

                                                @if($identifier === 'select')
                                                    <select id="attribute-{{ $attribute->id }}" wire:model="attributeValues.{{ $attribute->id }}" class="min-h-11 w-full rounded-xl border bg-white px-3 text-[13px] focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $errors->has($field) ? 'border-red-400' : 'border-hairline-strong' }}">
                                                        <option value="">Select {{ $attribute->name }}</option>
                                                        @foreach($attribute->values as $option)<option value="{{ $option->id }}">{{ $option->value }}</option>@endforeach
                                                    </select>
                                                    @if($canConfigure)
                                                        <label class="mt-2 flex cursor-pointer items-center gap-2 text-[11.5px] font-semibold text-primary"><input type="checkbox" wire:model.live="configurableAttributeIds" value="{{ $attribute->id }}" class="size-4 rounded border-hairline-strong text-primary"> Use as a variant option</label>
                                                    @endif
                                                @elseif($identifier === 'multiselect')
                                                    <div id="attribute-{{ $attribute->id }}" class="grid gap-2 rounded-xl border p-3 sm:grid-cols-2 {{ $errors->has($field) ? 'border-red-400 bg-red-50/30' : 'border-hairline bg-[#fafbfc]' }}">
                                                        @foreach($attribute->values as $option)<label class="flex cursor-pointer items-center gap-2 rounded-lg bg-white px-3 py-2 text-[12px]"><input type="checkbox" wire:model="attributeValues.{{ $attribute->id }}" value="{{ $option->id }}" class="size-4 rounded border-hairline-strong text-primary">{{ $option->value }}</label>@endforeach
                                                    </div>
                                                @elseif($identifier === 'textarea')
                                                    @if(\Illuminate\Support\Str::contains(\Illuminate\Support\Str::lower($attribute->code.' '.$attribute->name), 'description'))
                                                        <x-sysadmin::rich-text :label="$attribute->name" :model="$field" class="[&>label]:hidden" />
                                                    @else
                                                        <textarea id="attribute-{{ $attribute->id }}" wire:model="attributeValues.{{ $attribute->id }}" rows="4" class="w-full rounded-xl border px-3 py-2.5 text-[13px] focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $errors->has($field) ? 'border-red-400' : 'border-hairline-strong' }}"></textarea>
                                                    @endif
                                                @elseif($identifier === 'boolean')
                                                    <select id="attribute-{{ $attribute->id }}" wire:model="attributeValues.{{ $attribute->id }}" class="min-h-11 w-full rounded-xl border bg-white px-3 text-[13px] {{ $errors->has($field) ? 'border-red-400' : 'border-hairline-strong' }}"><option value="">Choose…</option><option value="1">Yes</option><option value="0">No</option></select>
                                                @elseif($identifier === 'date')
                                                    <input id="attribute-{{ $attribute->id }}" type="date" wire:model="attributeValues.{{ $attribute->id }}" class="min-h-11 w-full rounded-xl border px-3 text-[13px] {{ $errors->has($field) ? 'border-red-400' : 'border-hairline-strong' }}">
                                                @elseif($identifier === 'datetime')
                                                    <input id="attribute-{{ $attribute->id }}" type="datetime-local" wire:model="attributeValues.{{ $attribute->id }}" class="min-h-11 w-full rounded-xl border px-3 text-[13px] {{ $errors->has($field) ? 'border-red-400' : 'border-hairline-strong' }}">
                                                @elseif(in_array($identifier, ['number', 'price'], true))
                                                    <input id="attribute-{{ $attribute->id }}" type="number" step="{{ $identifier === 'price' ? '0.01' : 'any' }}" wire:model="attributeValues.{{ $attribute->id }}" class="min-h-11 w-full rounded-xl border px-3 text-[13px] {{ $errors->has($field) ? 'border-red-400' : 'border-hairline-strong' }}">
                                                @else
                                                    <input id="attribute-{{ $attribute->id }}" type="text" wire:model="attributeValues.{{ $attribute->id }}" class="min-h-11 w-full rounded-xl border px-3 text-[13px] {{ $errors->has($field) ? 'border-red-400' : 'border-hairline-strong' }}">
                                                @endif

                                                @error($field)<p class="mt-1 text-[11px] font-medium text-red-600">{{ $message }}</p>@enderror
                                                <p class="mt-1 text-[10px] text-ink-muted">{{ $attribute->attribute_type?->type_name ?? 'Text' }} @if($attribute->filterable)<span>· Storefront filter</span>@endif @if($attribute->comparable)<span>· Comparable</span>@endif</p>
                                            </div>
                                        @empty
                                            <div class="rounded-lg border border-dashed border-hairline-strong px-3 py-6 text-center text-xs text-ink-muted">No attributes assigned to this group.</div>
                                        @endforelse
                                    </div>
                                </fieldset>
                            @empty
                                <div class="rounded-xl border border-dashed border-hairline-strong bg-white px-4 py-8 text-center text-xs text-ink-muted">No groups in this family column.</div>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm">
                <header class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4">
                    <div><h2 class="text-base font-bold text-ink">Product variants</h2><p class="mt-1 text-xs text-ink-muted">Each row must have a unique SKU and a unique option combination.</p></div>
                    <x-sysadmin::btn wire:click="addVariant" :disabled="$configurableAttributeIds === []">{!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-4 w-4') !!} Add variant</x-sysadmin::btn>
                </header>

                @error('configurableAttributeIds')<div class="border-b border-red-100 bg-red-50 px-5 py-3 text-xs text-red-700">{{ $message }}</div>@enderror

                @if($configurableAttributeIds === [])
                    <div class="grid place-items-center px-5 py-12 text-center"><span class="grid size-11 place-items-center rounded-xl bg-primary-50 text-primary">{!! \Modules\SysAdmin\Support\Icon::get('layers') !!}</span><h3 class="mt-3 text-[13px] font-bold text-ink">Choose a variant attribute</h3><p class="mt-1 max-w-md text-xs text-ink-muted">Enable “Use as a variant option” on at least one configurable dropdown above.</p></div>
                @elseif($variants === [])
                    <div class="grid place-items-center px-5 py-12 text-center"><h3 class="text-[13px] font-bold text-ink">No variants yet</h3><p class="mt-1 text-xs text-ink-muted">Add a row for each sellable option combination.</p><x-sysadmin::btn wire:click="addVariant" class="mt-4">Add first variant</x-sysadmin::btn></div>
                @else
                    <div class="grid gap-3 bg-[#fafbfc] p-4">
                        @foreach($variants as $index => $variant)
                            <article wire:key="variant-row-{{ $variant['_key'] }}" class="rounded-xl border border-hairline bg-white shadow-sm">
                                <header class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-4 py-3"><div><strong class="text-[12.5px] text-ink">Variant {{ $index + 1 }}</strong><span class="ml-2 text-[10.5px] text-ink-muted">{{ $variant['sku'] ?: 'New SKU' }}</span></div><div class="flex gap-1"><button type="button" wire:click="duplicateVariant({{ $index }})" class="rounded-lg px-2.5 py-1.5 text-[11px] font-semibold text-primary hover:bg-primary-50">Duplicate</button><button type="button" wire:click="removeVariant({{ $index }})" wire:confirm="Remove this variant row?" class="rounded-lg px-2.5 py-1.5 text-[11px] font-semibold text-red-600 hover:bg-red-50">Remove</button></div></header>
                                <div class="grid gap-4 p-4 md:grid-cols-2 xl:grid-cols-4">
                                    <div><x-sysadmin::input label="Variant name" name="variants.{{ $index }}.name" wire:model="variants.{{ $index }}.name" /></div>
                                    <div><x-sysadmin::input label="SKU" name="variants.{{ $index }}.sku" wire:model="variants.{{ $index }}.sku" required /></div>
                                    <div><x-sysadmin::input label="Price" name="variants.{{ $index }}.price" type="number" min="0" step="0.01" wire:model="variants.{{ $index }}.price" required /></div>
                                    <div><x-sysadmin::input label="Stock" name="variants.{{ $index }}.stock" type="number" min="0" wire:model="variants.{{ $index }}.stock" required /></div>
                                    @foreach($variantAttributes as $attribute)
                                        <x-sysadmin::select label="{{ $attribute->name }}" name="variants.{{ $index }}.attributes.{{ $attribute->id }}" wire:model="variants.{{ $index }}.attributes.{{ $attribute->id }}" placeholder="Select option" required>@foreach($attribute->values as $option)<option value="{{ $option->id }}">{{ $option->value }}</option>@endforeach</x-sysadmin::select>
                                    @endforeach
                                    <x-sysadmin::select label="Status" name="variants.{{ $index }}.status" wire:model="variants.{{ $index }}.status"><option value="1">Active</option><option value="0">Inactive</option></x-sysadmin::select>
                                    <div class="md:col-span-2"><label class="mb-1.5 block text-[12.5px] font-bold text-ink">Variant image</label><input type="file" wire:model="variantUploads.{{ $index }}" accept="image/jpeg,image/png,image/gif,image/webp" class="block w-full rounded-xl border border-hairline-strong bg-white text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary">@error('variantUploads.'.$index)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                                    @php
                                        $preview = isset($variantUploads[$index])
                                            ? $variantUploads[$index]->temporaryUrl()
                                            : (($variant['thumb'] ?? null) && ! ($variant['remove_thumb'] ?? false) ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath($variant['thumb'], $product->created_at, 'thumbnail') : null);
                                    @endphp
                                    @if($preview)<div class="flex items-center gap-3"><img src="{{ $preview }}" class="size-16 rounded-lg border border-hairline object-cover" alt="Variant preview"><button type="button" wire:click="removeVariantImage({{ $index }})" class="text-[11px] font-semibold text-red-600">Remove image</button></div>@endif
                                    @error('variants.'.$index.'.attributes')<p class="md:col-span-full text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <aside class="grid content-start gap-4">
            <x-sysadmin::card class="sticky top-24 p-5">
                <h2 class="text-base font-bold text-ink">Product summary</h2>
                <dl class="mt-4 divide-y divide-hairline">
                    @foreach([['Product', $product->title], ['SKU', $product->sku ?: 'Not set'], ['Family', $family->name], ['Variants', count($variants)]] as [$label, $value])
                        <div class="py-3"><dt class="text-[10px] font-bold uppercase tracking-wide text-ink-muted">{{ $label }}</dt><dd class="mt-1 text-[13px] font-semibold text-ink">{{ $value }}</dd></div>
                    @endforeach
                </dl>
                <div class="mt-4 rounded-xl bg-primary-50 p-3 text-[11.5px] text-primary-700">Need another field? Create the attribute, then drag it into <a class="font-bold underline" href="{{ route('sysadmin.catalog.attribute.family.edit', $family->id) }}">this family’s structure</a>.</div>
            </x-sysadmin::card>
        </aside>
    </div>

    <div class="sticky bottom-4 z-10 flex items-center justify-between gap-3 rounded-xl border border-hairline bg-white/95 px-4 py-3 shadow-lg backdrop-blur"><p class="text-xs text-ink-muted">Live validation uses the selected attribute input types.</p><x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled">Save attributes & variants</x-sysadmin::btn></div>
</form>
