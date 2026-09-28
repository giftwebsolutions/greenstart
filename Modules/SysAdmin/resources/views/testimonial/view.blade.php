@extends('sysadmin::layouts.master')

@section('title', 'Testimonial Details')
@section('page-title', 'Testimonial Details')

@section('content')
    <div class="mx-auto grid max-w-5xl gap-5">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div><p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Social proof</p><h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">Testimonial details</h1><p class="mt-1 text-[13px] text-ink-muted">Review the storefront quote and customer profile.</p></div>
            <div class="flex gap-2"><x-sysadmin::btn href="{{ route('sysadmin.testimonial.index') }}">{!! \Modules\SysAdmin\Support\Icon::get('arrow-left', 'h-4 w-4') !!} Back to list</x-sysadmin::btn>@can('content.testimonials.update')<x-sysadmin::btn variant="primary" href="{{ route('sysadmin.testimonial.edit', $testimonial->id) }}">{!! \Modules\SysAdmin\Support\Icon::get('pencil', 'h-4 w-4') !!} Edit</x-sysadmin::btn>@endcan</div>
        </div>

        <x-sysadmin::card>
            <div class="grid gap-6 p-6 md:grid-cols-[180px_minmax(0,1fr)] md:p-8">
                <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="aspect-square w-full rounded-2xl border border-hairline bg-slate-100 object-cover">
                <div class="min-w-0"><span class="text-5xl font-black leading-none text-primary-50">“</span><blockquote class="-mt-3 whitespace-pre-line text-[17px] leading-8 text-ink">{{ $testimonial->content }}</blockquote><p class="mt-5 text-[15px] font-bold text-ink">{{ $testimonial->name }}</p><p class="mt-1 text-[11px] text-ink-muted">Testimonial #{{ $testimonial->id }}</p></div>
            </div>
            <dl class="grid border-t border-hairline bg-[#fafbfc] sm:grid-cols-2"><div class="px-6 py-4"><dt class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">Created</dt><dd class="mt-1 text-[12.5px] font-semibold text-ink">{{ $testimonial->created_at?->format('d M Y, h:i A') ?? '—' }}</dd></div><div class="border-t border-hairline px-6 py-4 sm:border-l sm:border-t-0"><dt class="text-[10px] font-bold uppercase tracking-wider text-ink-muted">Last updated</dt><dd class="mt-1 text-[12.5px] font-semibold text-ink">{{ $testimonial->updated_at?->format('d M Y, h:i A') ?? '—' }}</dd></div></dl>
        </x-sysadmin::card>
    </div>
@endsection
