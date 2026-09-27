@props(['variant' => 'secondary', 'type' => 'button', 'href' => null])
@php
    $base = 'inline-flex min-h-10 items-center justify-center gap-2 rounded-lg px-4 text-[13px] font-semibold transition disabled:cursor-not-allowed disabled:opacity-50';
    $variants = ['primary' => 'bg-primary text-white hover:bg-primary-600', 'secondary' => 'border border-hairline-strong bg-white text-ink hover:bg-slate-50', 'danger' => 'bg-red-600 text-white hover:bg-red-700', 'ghost' => 'text-ink-soft hover:bg-primary-50 hover:text-primary-600'];
    $classes = $base.' '.($variants[$variant] ?? $variants['secondary']);
@endphp
@if($href)<a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>@else<button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>@endif
