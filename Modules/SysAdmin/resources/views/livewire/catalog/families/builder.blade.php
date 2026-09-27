<div class="grid gap-5" x-data="familyWorkspace($wire)">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.catalog.attribute.family.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Attribute families</a>
            <h1 class="mt-2 text-[22px] font-bold tracking-tight text-ink">{{ $familyId ? $name : 'Create attribute family' }}</h1>
            <p class="mt-1 text-[13px] text-ink-muted">Arrange groups into two product-form columns and map reusable attributes.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            @if($structureDirty)<span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-[11.5px] font-semibold text-amber-700"><span class="size-1.5 rounded-full bg-amber-500"></span>Unsaved structure changes</span>@endif
            @if($familyId)
                <x-sysadmin::btn wire:click="discardStructureChanges" wire:confirm="Discard all unsaved group and attribute changes?" :disabled="! $structureDirty">Discard</x-sysadmin::btn>
                <x-sysadmin::btn variant="primary" wire:click="saveStructure" wire:loading.attr="disabled">{!! \Modules\SysAdmin\Support\Icon::get('check', 'h-4 w-4') !!}<span wire:loading.remove wire:target="saveStructure">Save structure</span><span wire:loading wire:target="saveStructure">Saving…</span></x-sysadmin::btn>
            @endif
        </div>
    </div>

    @error('group')<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13px] text-red-700">{{ $message }}</div>@enderror

    <x-sysadmin::card>
        <form wire:submit="saveDetails" class="grid gap-4 p-5 md:grid-cols-[minmax(0,1fr)_minmax(180px,.6fr)_170px_auto] md:items-end">
            <x-sysadmin::input label="Family name" name="name" wire:model.live.blur="name" placeholder="e.g. Domestic RO System" required/>
            <x-sysadmin::input label="Family code" name="code" wire:model="code" placeholder="domestic_ro" required class="font-mono" :disabled="$familyId !== null"/>
            <x-sysadmin::select label="Status" name="status" wire:model="status"><option value="1">Published</option><option value="2">Draft</option><option value="0">Disabled</option></x-sysadmin::select>
            <x-sysadmin::btn type="submit">Save details</x-sysadmin::btn>
        </form>
    </x-sysadmin::card>

    @if($family)
        <section class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4">
                <div><h2 class="text-base font-bold text-ink">Attribute mapping workspace</h2><p class="mt-1 text-xs text-ink-muted">Drag groups between layout columns. Drag attributes between groups or back to Unassigned.</p></div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-primary-50 px-3 py-1.5 text-[11.5px] font-semibold text-primary-600">{{ $assignedCount }} assigned</span>
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-[11.5px] font-semibold text-slate-600">{{ $totalAttributeCount - $assignedCount }} unassigned</span>
                    <x-sysadmin::btn wire:click="deleteSelectedGroup" wire:confirm="Delete the selected group? Its attributes will become unassigned." danger :disabled="! $selectedGroupKey">Delete group</x-sysadmin::btn>
                    <x-sysadmin::btn x-on:click="addGroupOpen = ! addGroupOpen">{!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-4 w-4') !!} Add group</x-sysadmin::btn>
                </div>
            </header>

            <div x-show="addGroupOpen" x-cloak x-transition class="border-b border-hairline bg-[#fafbfc] p-4">
                <form wire:submit="addGroup" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_180px_auto] md:items-end">
                    <x-sysadmin::input label="Group name" name="newGroupName" wire:model.live.blur="newGroupName" placeholder="e.g. Technical specifications" required/>
                    <x-sysadmin::input label="Group code" name="newGroupCode" wire:model="newGroupCode" placeholder="technical_specifications" required class="font-mono"/>
                    <x-sysadmin::select label="Product form column" name="newGroupColumn" wire:model="newGroupColumn"><option value="1">Main column</option><option value="2">Right column</option></x-sysadmin::select>
                    <x-sysadmin::btn type="submit" variant="primary">Add group</x-sysadmin::btn>
                </form>
            </div>

            <div class="grid min-h-[620px] xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_360px]">
                @foreach([1 => ['Main column', 'Primary product information'], 2 => ['Right column', 'Secondary and compact fields']] as $columnNumber => [$columnLabel, $columnHelp])
                    <section class="min-w-0 border-b border-hairline p-4 xl:border-b-0 xl:border-r" @dragover.prevent @drop.prevent="dropGroup({{ $columnNumber }}, $event)">
                        <div class="mb-4 flex items-start justify-between gap-3"><div><h3 class="text-[13px] font-bold text-ink">{{ $columnLabel }}</h3><p class="mt-1 text-[11px] text-ink-muted">{{ $columnHelp }}</p></div><span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10.5px] font-semibold text-ink-muted">{{ count($columns[$columnNumber]) }} groups</span></div>
                        <div class="grid content-start gap-3">
                            @forelse($columns[$columnNumber] as $groupIndex => $group)
                                <article wire:key="{{ $group['key'] }}" draggable="true" @dragstart="startGroup(@js($group['key']), $event)" @click="$wire.selectGroup(@js($group['key']))" class="overflow-hidden rounded-xl border bg-white transition {{ $selectedGroupKey === $group['key'] ? 'border-primary ring-2 ring-primary-50' : 'border-hairline hover:border-primary/30' }}">
                                    <header class="flex items-center gap-2 bg-[#fafbfc] px-3 py-2.5">
                                        <button type="button" wire:click.stop="toggleGroup(@js($group['key']))" class="grid size-7 place-items-center rounded-md text-ink-muted hover:bg-white" aria-label="Toggle group"><span class="transition {{ $group['collapsed'] ? '-rotate-90' : '' }}">{!! \Modules\SysAdmin\Support\Icon::get('chevron-down', 'h-3.5 w-3.5') !!}</span></button>
                                        <span class="cursor-grab text-ink-muted" title="Drag group">⋮⋮</span>
                                        <span class="grid size-7 shrink-0 place-items-center rounded-lg {{ $group['is_user_defined'] ? 'bg-primary-50 text-primary' : 'bg-slate-200 text-slate-600' }}">{!! \Modules\SysAdmin\Support\Icon::get($group['is_user_defined'] ? 'folder' : 'lock', 'h-3.5 w-3.5') !!}</span>
                                        <div class="min-w-0 flex-1"><input value="{{ $group['name'] }}" @change="$wire.renameGroup(@js($group['key']), $event.target.value)" class="w-full truncate bg-transparent text-[12.5px] font-bold text-ink outline-none focus:text-primary" aria-label="Group name"><code class="block truncate text-[9.5px] text-ink-muted">{{ $group['code'] }}</code></div>
                                        <span class="rounded-full bg-white px-2 py-1 text-[10px] font-semibold text-ink-muted shadow-sm">{{ count($group['attributes']) }}</span>
                                        <div class="flex"><button type="button" wire:click.stop="nudgeGroup(@js($group['key']), 'up')" class="grid size-7 place-items-center rounded text-ink-muted hover:bg-white">↑</button><button type="button" wire:click.stop="nudgeGroup(@js($group['key']), 'down')" class="grid size-7 place-items-center rounded text-ink-muted hover:bg-white">↓</button></div>
                                    </header>

                                    @unless($group['collapsed'])
                                        <div class="grid min-h-14 gap-1.5 p-2" @dragover.prevent @drop.stop.prevent="dropAttribute(@js($group['key']), $event)">
                                            @forelse($group['attributes'] as $attributeId)
                                                @php($attribute = $attributesById->get((int) $attributeId))
                                                @if($attribute)
                                                <div wire:key="{{ $group['key'] }}-attribute-{{ $attributeId }}" draggable="true" @dragstart.stop="startAttribute({{ $attributeId }}, $event)" class="group flex cursor-grab items-center gap-2 rounded-lg border border-transparent px-2.5 py-2 hover:border-hairline hover:bg-[#fafbfc]">
                                                    <span class="text-ink-muted">⋮⋮</span><span class="grid size-7 shrink-0 place-items-center rounded-md bg-slate-100 text-ink-muted">{!! \Modules\SysAdmin\Support\Icon::get('tag', 'h-3.5 w-3.5') !!}</span>
                                                    <span class="min-w-0 flex-1"><strong class="block truncate text-[11.5px] font-semibold text-ink">{{ $attribute->name }}</strong><small class="block truncate text-[9.5px] text-ink-muted">{{ $attribute->code }} · {{ $attribute->attribute_type?->type_name }}</small></span>
                                                    @if($attribute->require)<span class="size-1.5 rounded-full bg-red-500" title="Required"></span>@endif
                                                    @if($attribute->configurable)<span class="rounded bg-primary-50 px-1.5 py-0.5 text-[8.5px] font-bold text-primary">VARIANT</span>@endif
                                                    <div class="hidden group-hover:flex"><button type="button" wire:click.stop="nudgeAttribute(@js($group['key']), {{ $attributeId }}, 'up')" class="grid size-6 place-items-center text-ink-muted">↑</button><button type="button" wire:click.stop="nudgeAttribute(@js($group['key']), {{ $attributeId }}, 'down')" class="grid size-6 place-items-center text-ink-muted">↓</button><button type="button" wire:click.stop="unassignAttribute({{ $attributeId }})" class="grid size-6 place-items-center text-red-500">×</button></div>
                                                </div>
                                                @endif
                                            @empty
                                                <div class="grid min-h-14 place-items-center rounded-lg border border-dashed border-primary/30 bg-primary-50/40 px-3 text-[10.5px] font-semibold text-primary-600">Drop attributes into {{ $group['name'] }}</div>
                                            @endforelse
                                        </div>
                                    @endunless
                                </article>
                            @empty
                                <div class="grid min-h-40 place-items-center rounded-xl border border-dashed border-hairline-strong bg-[#fafbfc] p-5 text-center"><div><span class="mx-auto grid size-9 place-items-center rounded-lg bg-white text-ink-muted shadow-sm">{!! \Modules\SysAdmin\Support\Icon::get('folder') !!}</span><p class="mt-2 text-xs font-semibold text-ink">No groups in this column</p><p class="mt-1 text-[10.5px] text-ink-muted">Add a group or drag one here.</p></div></div>
                            @endforelse
                        </div>
                    </section>
                @endforeach

                <aside class="min-w-0 bg-[#fafbfc] p-4" @dragover.prevent @drop.prevent="dropUnassigned($event)">
                    <div class="mb-3"><div class="flex items-start justify-between gap-3"><div><h3 class="text-[13px] font-bold text-ink">Unassigned attributes</h3><p class="mt-1 text-[11px] text-ink-muted">Drag attributes into a group.</p></div><x-sysadmin::btn :href="route('sysadmin.catalog.attribute.create')" class="min-h-8 px-2.5 text-[11px]">New</x-sysadmin::btn></div>
                        <div class="relative mt-3"><span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink-muted">{!! \Modules\SysAdmin\Support\Icon::get('search', 'h-4 w-4') !!}</span><input wire:model.live.debounce.250ms="attributeSearch" type="search" class="min-h-10 w-full rounded-lg border border-hairline-strong bg-white pl-9 pr-3 text-[12px] focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50" placeholder="Search name, code or type"></div>
                    </div>
                    <div class="max-h-[660px] space-y-1.5 overflow-y-auto pr-1">
                        @forelse($availableAttributes as $attribute)
                            <div wire:key="unassigned-attribute-{{ $attribute->id }}" draggable="true" @dragstart="startAttribute({{ $attribute->id }}, $event)" class="group flex cursor-grab items-center gap-2 rounded-lg border border-hairline bg-white px-2.5 py-2.5 hover:border-primary/40 hover:shadow-sm">
                                <span class="text-ink-muted">⋮⋮</span><span class="grid size-7 shrink-0 place-items-center rounded-md bg-primary-50 text-primary">{!! \Modules\SysAdmin\Support\Icon::get('tag', 'h-3.5 w-3.5') !!}</span>
                                <span class="min-w-0 flex-1"><strong class="block truncate text-[11.5px] font-semibold text-ink">{{ $attribute->name }}</strong><small class="block truncate text-[9.5px] text-ink-muted">{{ $attribute->code }} · {{ $attribute->attribute_type?->type_name }}</small></span>
                                <div class="flex gap-1">@if($attribute->filterable)<span class="rounded bg-blue-50 px-1.5 py-0.5 text-[8px] font-bold text-blue-700">FILTER</span>@endif @if($attribute->configurable)<span class="rounded bg-primary-50 px-1.5 py-0.5 text-[8px] font-bold text-primary">VARIANT</span>@endif</div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-hairline-strong bg-white px-4 py-10 text-center"><p class="text-xs font-semibold text-ink">No unassigned attributes</p><p class="mt-1 text-[10.5px] text-ink-muted">All matching attributes are mapped.</p></div>
                        @endforelse
                    </div>
                </aside>
            </div>
        </section>

        <div class="sticky bottom-4 z-10 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-hairline bg-white/95 px-4 py-3 shadow-lg backdrop-blur">
            <p class="text-xs text-ink-muted"><strong class="text-ink">{{ $assignedCount }} of {{ $totalAttributeCount }}</strong> attributes assigned across {{ count($columns[1]) + count($columns[2]) }} groups.</p>
            <div class="flex gap-2"><x-sysadmin::btn wire:click="discardStructureChanges" :disabled="! $structureDirty">Discard changes</x-sysadmin::btn><x-sysadmin::btn variant="primary" wire:click="saveStructure" wire:loading.attr="disabled">Save family structure</x-sysadmin::btn></div>
        </div>
    @else
        <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-[13px] text-blue-700">Save the family name and code first. The Magento/Bagisto-style mapping workspace will then open.</div>
    @endif

    @script
    <script>
        Alpine.data('familyWorkspace', (wire) => ({
            addGroupOpen: false,
            dragType: null,
            dragKey: null,
            startGroup(key, event) { this.dragType = 'group'; this.dragKey = key; event.dataTransfer.effectAllowed = 'move'; event.dataTransfer.setData('application/x-family-group', key); },
            startAttribute(id, event) { this.dragType = 'attribute'; this.dragKey = id; event.dataTransfer.effectAllowed = 'move'; event.dataTransfer.setData('application/x-family-attribute', String(id)); },
            dropGroup(column, event) { if (this.dragType !== 'group') return; const key = event.dataTransfer.getData('application/x-family-group') || this.dragKey; if (key) wire.moveGroup(key, column); this.clearDrag(); },
            dropAttribute(groupKey, event) { if (this.dragType !== 'attribute') return; const id = Number(event.dataTransfer.getData('application/x-family-attribute') || this.dragKey); if (id) wire.assignAttribute(id, groupKey); this.clearDrag(); },
            dropUnassigned(event) { if (this.dragType !== 'attribute') return; const id = Number(event.dataTransfer.getData('application/x-family-attribute') || this.dragKey); if (id) wire.unassignAttribute(id); this.clearDrag(); },
            clearDrag() { this.dragType = null; this.dragKey = null; },
        }));
    </script>
    @endscript
</div>
