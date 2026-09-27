@props([
    'label',
    'name',
    'value' => '',
    'required' => false,
    'hint' => null,
    'rows' => 6,
])

<div {{ $attributes }}>
    <label for="{{ $name }}" class="mb-1.5 block text-[12.5px] font-bold text-ink">
        {{ $label }}
        @if($required)<span class="text-red-600">*</span>@endif
    </label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        class="editor min-h-32 w-full rounded-xl border bg-white px-3 py-2.5 text-[13px] text-ink focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $errors->has($name) ? 'border-red-500' : 'border-hairline-strong' }}"
        @required($required)
    >{{ old($name, $value) }}</textarea>
    @if($hint && ! $errors->has($name))<p class="mt-1.5 text-[11px] leading-relaxed text-ink-muted">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
</div>
