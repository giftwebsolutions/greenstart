@props(['label' => null, 'name' => '', 'required' => false, 'placeholder' => null, 'size' => 'default', 'wrapperClass' => ''])
@php
    $isCompact = $size === 'sm';
    $controlClasses = $isCompact
        ? 'min-h-10 w-full rounded-lg border border-hairline-strong bg-white px-3 text-[13px] text-ink focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50'
        : 'min-h-11 w-full rounded-xl border border-hairline-strong bg-white px-3 text-[13.5px] text-ink focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50';
@endphp
<div @class([$wrapperClass])>
    @if($label)<label class="{{ $isCompact ? 'mb-1 text-[12px]' : 'mb-1.5 text-[12.5px]' }} block font-bold text-ink">{{ $label }}@if($required)<span class="text-red-600"> *</span>@endif</label>@endif
    <select @if($name) name="{{ $name }}" @endif @required($required) {{ $attributes->merge(['class' => $controlClasses]) }}>@if($placeholder)<option value="">{{ $placeholder }}</option>@endif{{ $slot }}</select>
    @error($name)<p class="{{ $isCompact ? 'mt-1 text-[11px]' : 'mt-1.5 text-xs' }} font-medium text-red-600">{{ $message }}</p>@enderror
</div>
