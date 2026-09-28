@php
    $enquiry = $enquiry ?? null;
    $editing = filled($enquiry);
@endphp

<form method="POST" action="{{ $editing ? route('sysadmin.enquiry.update', $enquiry->id) : route('sysadmin.enquiry.store') }}" class="grid gap-4">
    @csrf
    @if($editing) @method('PATCH') @endif

    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('sysadmin.enquiry.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-3.5 w-3.5') !!} Enquiry CRM</a>
            <h1 class="mt-1.5 text-xl font-bold tracking-tight text-ink">{{ $editing ? 'Edit enquiry' : 'Create enquiry' }}</h1>
            <p class="mt-0.5 text-xs text-ink-muted">Capture the customer request, commercial context and CRM ownership.</p>
        </div>
        <div class="flex gap-2">
            <x-sysadmin::btn :href="$editing ? route('sysadmin.enquiry.view', $enquiry->id) : route('sysadmin.enquiry.index')">Cancel</x-sysadmin::btn>
            <x-sysadmin::btn type="submit" variant="primary">{{ $editing ? 'Save enquiry' : 'Create enquiry' }}</x-sysadmin::btn>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <strong class="block font-bold">Please correct the highlighted fields.</strong>
            <ul class="mt-2 list-disc space-y-1 pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
        <div class="grid gap-4">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Customer</h2><p class="mt-0.5 text-[11px] text-ink-muted">Contact and location details used by follow-ups and appointments.</p></div>
                <div class="grid gap-4 p-4 md:grid-cols-2">
                    <x-sysadmin::input label="Customer name" name="name" :value="old('name', $enquiry?->name)" size="sm" required autofocus />
                    <x-sysadmin::input label="Mobile" name="mobile" :value="old('mobile', $enquiry?->mobile)" size="sm" required />
                    <x-sysadmin::input label="Email" name="email" type="email" :value="old('email', $enquiry?->email)" size="sm" />
                    <x-sysadmin::input label="Enquiry source" name="enquiry_type" :value="old('enquiry_type', $enquiry?->enquiry_type)" placeholder="Website, phone, referral…" size="sm" />
                    <x-sysadmin::input label="City" name="city" :value="old('city', $enquiry?->city)" size="sm" />
                    <x-sysadmin::input label="State" name="state" :value="old('state', $enquiry?->state)" size="sm" />
                </div>
            </x-sysadmin::card>

            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Request details</h2></div>
                <div class="grid gap-4 p-4">
                    <x-sysadmin::input label="Subject" name="subject" :value="old('subject', $enquiry?->subject)" placeholder="What does the customer need?" size="sm" />
                    <div><label for="message" class="mb-1 block text-[12px] font-bold text-ink">Customer message <span class="text-red-600">*</span></label><textarea id="message" name="message" rows="4" required class="w-full rounded-lg border bg-white px-3 py-2.5 text-[13px] text-ink focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $errors->has('message') ? 'border-red-500' : 'border-hairline-strong' }}">{{ old('message', $enquiry?->message) }}</textarea>@error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                    <div><label for="internal_notes" class="mb-1 block text-[12px] font-bold text-ink">Internal notes</label><textarea id="internal_notes" name="internal_notes" rows="4" class="w-full rounded-lg border border-hairline-strong bg-white px-3 py-2.5 text-[13px] text-ink focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50">{{ old('internal_notes', $enquiry?->internal_notes) }}</textarea><p class="mt-1 text-[11px] text-ink-muted">Visible only to administrators.</p>@error('internal_notes')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                </div>
            </x-sysadmin::card>

            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">Product and commercial details</h2></div>
                <div class="grid gap-4 p-4 md:grid-cols-2">
                    <x-sysadmin::select label="Category" name="category_id" size="sm"><option value="">No category</option>@foreach($categories as $id => $name)<option value="{{ $id }}" @selected((string) old('category_id', $enquiry?->category_id ?: '') === (string) $id)>{{ $name }}</option>@endforeach</x-sysadmin::select>
                    <x-sysadmin::select label="Product" name="product_id" size="sm"><option value="">No product</option>@foreach($products as $product)<option value="{{ $product->id }}" data-category="{{ $product->product_category }}" @selected((string) old('product_id', $enquiry?->product_id ?: '') === (string) $product->id)>{{ $product->title }}</option>@endforeach</x-sysadmin::select>
                    <x-sysadmin::input label="Quantity" name="qty" type="number" min="0.01" step="0.01" :value="old('qty', $enquiry?->qty)" size="sm" />
                    <x-sysadmin::input label="List price" name="price" type="number" min="0" step="0.01" :value="old('price', $enquiry?->price)" size="sm" />
                    <x-sysadmin::input label="Requested price" name="req_price" type="number" min="0" step="0.01" :value="old('req_price', $enquiry?->req_price)" wrapper-class="md:col-span-2" size="sm" />
                </div>
            </x-sysadmin::card>
        </div>

        <aside class="grid content-start gap-4">
            <x-sysadmin::card>
                <div class="border-b border-hairline px-4 py-3"><h2 class="text-sm font-bold text-ink">CRM workflow</h2></div>
                <div class="grid gap-4 p-4">
                    <x-sysadmin::select label="Status" name="status" size="sm" required>@foreach($statuses as $key => $label)<option value="{{ $key }}" @selected((string) old('status', $enquiry?->status ?? \Modules\SysAdmin\Models\Enquiry::STATUS_NEW) === (string) $key)>{{ $label }}</option>@endforeach</x-sysadmin::select>
                    <x-sysadmin::select label="Priority" name="priority" size="sm" required>@foreach($priorities as $key => $label)<option value="{{ $key }}" @selected(old('priority', $enquiry?->priority ?? 'normal') === $key)>{{ $label }}</option>@endforeach</x-sysadmin::select>
                    <x-sysadmin::select label="Assigned to" name="assigned_to" size="sm"><option value="">Unassigned</option>@foreach($users as $user)<option value="{{ $user->id }}" @selected((string) old('assigned_to', $enquiry?->assigned_to) === (string) $user->id)>{{ $user->name }}</option>@endforeach</x-sysadmin::select>
                </div>
            </x-sysadmin::card>
            @if($editing)
                <x-sysadmin::card padded>
                    <h3 class="text-sm font-bold text-ink">Continue in workspace</h3>
                    <p class="mt-1 text-[11.5px] leading-relaxed text-ink-muted">Schedule follow-ups and appointments or review the complete activity timeline.</p>
                    <x-sysadmin::btn class="mt-4 w-full" :href="route('sysadmin.enquiry.view', $enquiry->id)">Open workspace</x-sysadmin::btn>
                </x-sysadmin::card>
            @endif
        </aside>
    </div>
</form>
