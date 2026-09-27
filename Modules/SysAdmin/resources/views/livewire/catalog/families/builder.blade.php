<div class="catalog-workspace">
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div><a href="{{ route('sysadmin.catalog.attribute.family.index') }}" class="small text-decoration-none">← Attribute families</a><h4 class="mt-2 mb-1">{{ $familyId ? $name : 'Create attribute family' }}</h4><p class="text-muted mb-0">Drag attributes into groups, then refine their display order.</p></div>
        @if ($familyId)<a href="{{ route('sysadmin.catalog.attribute.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus me-1"></i>New attribute</a>@endif
    </div>

    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <form wire:submit="saveDetails" class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-lg-5"><label class="form-label">Family name</label><input wire:model.live.blur="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Domestic RO System">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-lg-3"><label class="form-label">Code</label><input wire:model="code" class="form-control font-monospace @error('code') is-invalid @enderror" placeholder="domestic_ro">@error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-2"><label class="form-label">Status</label><select wire:model="status" class="form-select"><option value="1">Published</option><option value="2">Draft</option><option value="0">Disabled</option></select></div>
                <div class="col-sm-6 col-lg-2 d-grid"><button class="btn btn-primary">Save details</button></div>
            </div>
        </form>
    </div>

    @if ($family)
        <div class="row g-4" x-data="familyBuilder($wire)">
            <div class="col-xl-8">
                <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Family layout</h5><span class="small text-muted">Drop attributes on a group</span></div>
                <div class="vstack gap-3">
                    @foreach ($family->groups as $group)
                        <section class="family-builder-group" wire:key="family-group-{{ $group->id }}" @dragover.prevent @drop.prevent="assignTo({{ $group->id }}, $event)">
                            <header>
                                <div class="d-flex align-items-center gap-2 flex-grow-1">
                                    <span class="drag-handle"><i class="fa fa-grip-vertical"></i></span>
                                    <input value="{{ $group->name }}" @change="$wire.renameGroup({{ $group->id }}, $event.target.value)" class="group-name-input" aria-label="Group name">
                                    <span class="badge rounded-pill text-bg-light">{{ $group->attributes->count() }}</span>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" wire:click="moveGroup({{ $group->id }}, 'up')" class="btn btn-outline-secondary" title="Move group up">↑</button>
                                    <button type="button" wire:click="moveGroup({{ $group->id }}, 'down')" class="btn btn-outline-secondary" title="Move group down">↓</button>
                                    @if ($group->is_user_defined)<button type="button" wire:click="deleteGroup({{ $group->id }})" wire:confirm="Delete this group? Its attributes will move to General." class="btn btn-outline-danger" title="Delete group">×</button>@endif
                                </div>
                            </header>
                            <div class="group-attribute-list">
                                @forelse ($group->attributes as $attribute)
                                    <article class="attribute-chip" draggable="true" @dragstart="start({{ $attribute->id }}, $event)" wire:key="group-{{ $group->id }}-attribute-{{ $attribute->id }}">
                                        <span class="drag-handle"><i class="fa fa-grip-vertical"></i></span>
                                        <span class="flex-grow-1"><strong>{{ $attribute->name }}</strong><small>{{ $attribute->code }} · {{ $attribute->attribute_type?->type_name }}</small></span>
                                        <span class="d-flex gap-1">
                                            @if ($attribute->require)<span class="mini-flag">Required</span>@endif
                                            @if ($attribute->configurable)<span class="mini-flag mini-flag-primary">Variant</span>@endif
                                        </span>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" wire:click="moveAttribute({{ $group->id }}, {{ $attribute->id }}, 'up')" class="btn btn-light" aria-label="Move up">↑</button>
                                            <button type="button" wire:click="moveAttribute({{ $group->id }}, {{ $attribute->id }}, 'down')" class="btn btn-light" aria-label="Move down">↓</button>
                                            <button type="button" wire:click="unassignAttribute({{ $attribute->id }})" class="btn btn-light text-danger" aria-label="Unassign">×</button>
                                        </div>
                                    </article>
                                @empty
                                    <div class="group-empty">Drop attributes here</div>
                                @endforelse
                            </div>
                        </section>
                    @endforeach
                </div>

                <form wire:submit="addGroup" class="card border-0 shadow-sm mt-3"><div class="card-body d-flex gap-2"><input wire:model="newGroupName" class="form-control @error('newGroupName') is-invalid @enderror" placeholder="New group name"><button class="btn btn-outline-primary text-nowrap"><i class="fa fa-plus me-1"></i>Add group</button></div></form>
            </div>

            <aside class="col-xl-4">
                <div class="card border-0 shadow-sm sticky-xl-top" style="top: 1rem">
                    <div class="card-header bg-white py-3"><h5 class="mb-1">Available attributes</h5><small class="text-muted">Drag one into a group.</small></div>
                    <div class="card-body border-bottom"><input wire:model.live.debounce.250ms="attributeSearch" type="search" class="form-control" placeholder="Search attributes"></div>
                    <div class="available-attributes">
                        @forelse ($availableAttributes as $attribute)
                            <article class="available-attribute" draggable="true" @dragstart="start({{ $attribute->id }}, $event)" wire:key="available-attribute-{{ $attribute->id }}">
                                <span class="drag-handle"><i class="fa fa-grip-vertical"></i></span><span><strong>{{ $attribute->name }}</strong><small>{{ $attribute->code }} · {{ $attribute->attribute_type?->type_name }}</small></span>
                            </article>
                        @empty
                            <div class="p-4 text-center text-muted">All matching attributes are assigned.</div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    @else
        <div class="alert alert-info">Save family details to open the group and attribute builder.</div>
    @endif

    @script
    <script>
        Alpine.data('familyBuilder', (wire) => ({
            draggedAttribute: null,
            start(id, event) {
                this.draggedAttribute = id;
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', String(id));
            },
            assignTo(groupId, event) {
                const id = Number(event.dataTransfer.getData('text/plain') || this.draggedAttribute);
                if (id) wire.assignAttribute(id, groupId);
                this.draggedAttribute = null;
            },
        }));
    </script>
    @endscript
</div>
