@props(['label' => null, 'name' => '', 'type' => 'text', 'required' => false, 'hint' => null, 'size' => 'default', 'wrapperClass' => ''])
@php
    $isCompact = $size === 'sm';
    $controlClasses = $isCompact
        ? 'min-h-10 w-full rounded-lg border bg-white px-3 text-[13px] text-ink placeholder:text-ink-muted focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50'
        : 'min-h-11 w-full rounded-xl border bg-white px-3 text-[13.5px] text-ink placeholder:text-ink-muted focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50';
@endphp
<div @class([$wrapperClass])>
    @if($label)<label class="{{ $isCompact ? 'mb-1 text-[12px]' : 'mb-1.5 text-[12.5px]' }} block font-bold text-ink">{{ $label }}@if($required)<span class="text-red-600"> *</span>@endif</label>@endif
    <input type="{{ $type }}" @if($name) name="{{ $name }}" @endif @required($required) {{ $attributes->merge(['class' => $controlClasses.' '.($errors->has($name) ? 'border-red-500' : 'border-hairline-strong')]) }}>
    @if($hint && !$errors->has($name))<p class="{{ $isCompact ? 'mt-1 text-[11px]' : 'mt-1.5 text-xs' }} leading-relaxed text-ink-muted">{{ $hint }}</p>@endif
    @error($name)<p class="{{ $isCompact ? 'mt-1 text-[11px]' : 'mt-1.5 text-xs' }} font-medium text-red-600">{{ $message }}</p>@enderror
</div>
