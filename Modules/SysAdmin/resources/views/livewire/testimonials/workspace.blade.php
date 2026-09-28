<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Social proof</p>
            <h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">Testimonials</h1>
            <p class="mt-1 text-[13px] text-ink-muted">Manage customer quotes and the profile images shown on the storefront.</p>
        </div>
        @can('content.testimonials.create')
            <x-sysadmin::btn variant="primary" wire:click="create">{!! \Modules\SysAdmin\Support\Icon::get('plus', 'h-4 w-4') !!} Add testimonial</x-sysadmin::btn>
        @endcan
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <x-sysadmin::card padded><p class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">Total testimonials</p><p class="mt-2 text-[24px] font-bold text-ink">{{ number_format($stats['total']) }}</p></x-sysadmin::card>
        <x-sysadmin::card padded><p class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">With profile image</p><p class="mt-2 text-[24px] font-bold text-ink">{{ number_format($stats['with_image']) }}</p></x-sysadmin::card>
        <x-sysadmin::card padded><p class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">Updated this month</p><p class="mt-2 text-[24px] font-bold text-ink">{{ number_format($stats['updated_this_month']) }}</p></x-sysadmin::card>
    </div>

    <x-sysadmin::table-toolbar search-placeholder="Search name or testimonial…">
        <select wire:model.live="perPage" class="min-h-11 rounded-xl border border-hairline-strong bg-white px-3 text-[12.5px] font-semibold text-ink focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50" aria-label="Rows per page"><option value="12">12 rows</option><option value="24">24 rows</option><option value="48">48 rows</option></select>
    </x-sysadmin::table-toolbar>

    <div wire:loading.class="opacity-60" class="overflow-x-auto rounded-xl border border-hairline bg-white shadow-sm transition">
        <table class="w-full min-w-[760px] border-collapse">
            <thead><tr><x-sysadmin::th>Customer</x-sysadmin::th><x-sysadmin::th>Testimonial</x-sysadmin::th><x-sysadmin::th>Updated</x-sysadmin::th><x-sysadmin::th align="right">Actions</x-sysadmin::th></tr></thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                    <tr wire:key="testimonial-{{ $testimonial->id }}" class="hover:bg-[#fafbfc]">
                        <x-sysadmin::td><div class="flex items-center gap-3"><img src="{{ $testimonial->image_url }}" alt="" class="size-11 rounded-xl border border-hairline bg-slate-100 object-cover"><div><strong class="block text-[13px] text-ink">{{ $testimonial->name }}</strong><small class="mt-0.5 block text-[10px] text-ink-muted">#{{ $testimonial->id }}</small></div></div></x-sysadmin::td>
                        <x-sysadmin::td><p class="max-w-2xl text-[12.5px] leading-5 text-ink-soft">“{{ \Illuminate\Support\Str::limit(strip_tags($testimonial->content), 150) }}”</p></x-sysadmin::td>
                        <x-sysadmin::td><span class="whitespace-nowrap text-[12px] text-ink-muted">{{ $testimonial->updated_at?->format('d M Y') ?? '—' }}</span></x-sysadmin::td>
                        <x-sysadmin::td align="right"><div class="flex justify-end gap-1"><x-sysadmin::icon-button icon="eye" label="View testimonial" href="{{ route('sysadmin.testimonial.view', $testimonial->id) }}" />@can('content.testimonials.update')<x-sysadmin::icon-button icon="pencil" label="Edit testimonial" wire:click="edit({{ $testimonial->id }})" />@endcan @can('content.testimonials.delete')<x-sysadmin::icon-button icon="trash" label="Delete testimonial" danger wire:click="confirmDelete({{ $testimonial->id }})" />@endcan</div></x-sysadmin::td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-14 text-center"><span class="mx-auto grid size-11 place-items-center rounded-full bg-primary-50 text-primary">{!! \Modules\SysAdmin\Support\Icon::get('message') !!}</span><p class="mt-3 text-[13px] font-semibold text-ink">No testimonials found</p><p class="mt-1 text-xs text-ink-muted">Add a customer quote or try another search term.</p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($testimonials->hasPages())<div>{{ $testimonials->links() }}</div>@endif

    @if($drawerOpen)
        <div wire:key="testimonial-drawer-{{ $editingId ?: 'create' }}" class="fixed inset-0 z-50" role="dialog" aria-modal="true">
            <button type="button" wire:click="closeDrawer" class="absolute inset-0 bg-slate-950/40" aria-label="Close testimonial form"></button>
            <aside class="absolute inset-y-0 right-0 w-full max-w-2xl overflow-y-auto bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-hairline px-6 py-5"><div><h2 class="text-lg font-bold text-ink">{{ $editingId ? 'Edit testimonial' : 'Add testimonial' }}</h2><p class="mt-1 text-xs text-ink-muted">Keep the quote concise and use a clear, square customer photo.</p></div><button type="button" wire:click="closeDrawer" class="grid size-9 place-items-center rounded-lg text-ink-muted hover:bg-slate-100" aria-label="Close">×</button></div>
                <form wire:submit="save" class="grid gap-5 p-6">
                    <x-sysadmin::input label="Customer name" name="name" wire:model="name" placeholder="e.g. Priya Raman" required />
                    <div><label class="mb-1.5 block text-[12.5px] font-bold text-ink">Testimonial <span class="text-red-600">*</span></label><textarea name="content" wire:model="content" rows="7" maxlength="5000" placeholder="Write the customer quote…" class="w-full rounded-xl border bg-white px-3 py-2.5 text-[13.5px] leading-6 text-ink placeholder:text-ink-muted focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $errors->has('content') ? 'border-red-500' : 'border-hairline-strong' }}"></textarea><div class="mt-1 flex justify-between gap-3"><p class="text-[11px] text-ink-muted">Plain text is recommended for clean storefront presentation.</p><span class="text-[10px] text-ink-muted">{{ mb_strlen($content) }} / 5000</span></div>@error('content')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror</div>

                    <div class="rounded-xl border border-hairline p-4">
                        <div class="flex items-start justify-between gap-4"><div><label class="text-[12.5px] font-bold text-ink">Customer image</label><p class="mt-1 text-[11px] text-ink-muted">JPG, PNG or WebP up to 4 MB. A square image works best.</p></div>@if($image || ($existingImageUrl && ! $removeImage))<button type="button" wire:click="clearImage" class="text-[11px] font-bold text-red-600 hover:text-red-700">Remove image</button>@endif</div>
                        <div class="mt-4 grid gap-4 sm:grid-cols-[128px_minmax(0,1fr)] sm:items-center">
                            <div class="grid aspect-square place-items-center overflow-hidden rounded-xl border border-dashed border-hairline-strong bg-[#fafbfc]">
                                @if($image)<img src="{{ $image->temporaryUrl() }}" alt="Selected testimonial image" class="size-full object-cover">@elseif($existingImageUrl && ! $removeImage)<img src="{{ $existingImageUrl }}" alt="Current testimonial image" class="size-full object-cover">@else<span class="text-ink-muted">{!! \Modules\SysAdmin\Support\Icon::get('image', 'h-7 w-7') !!}</span>@endif
                            </div>
                            <div><input type="file" wire:model="image" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-hairline-strong bg-white text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary"><p wire:loading wire:target="image" class="mt-2 text-[11px] font-semibold text-primary">Preparing preview…</p>@error('image')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror</div>
                        </div>
                    </div>

                    <div class="mt-1 flex justify-end gap-2 border-t border-hairline pt-5"><x-sysadmin::btn wire:click="closeDrawer">Cancel</x-sysadmin::btn><x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled"><span wire:loading.remove wire:target="save">{{ $editingId ? 'Update testimonial' : 'Create testimonial' }}</span><span wire:loading wire:target="save">Saving…</span></x-sysadmin::btn></div>
                </form>
            </aside>
        </div>
    @endif

    @if($confirmingDelete)
        <div class="fixed inset-0 z-50 grid place-items-center bg-slate-950/40 p-4" role="dialog" aria-modal="true"><div class="w-full max-w-md rounded-xl bg-white p-6 shadow-2xl"><span class="grid size-10 place-items-center rounded-xl bg-red-50 text-red-600">{!! \Modules\SysAdmin\Support\Icon::get('trash', 'h-5 w-5') !!}</span><h2 class="mt-4 text-lg font-bold text-ink">Delete testimonial?</h2><p class="mt-2 text-[13px] text-ink-muted">The customer quote and its uploaded image will be permanently removed.</p><div class="mt-6 flex justify-end gap-2"><x-sysadmin::btn wire:click="$set('confirmingDelete', null)">Cancel</x-sysadmin::btn><x-sysadmin::btn variant="danger" wire:click="delete" wire:loading.attr="disabled">Delete testimonial</x-sysadmin::btn></div></div></div>
    @endif
</div>
