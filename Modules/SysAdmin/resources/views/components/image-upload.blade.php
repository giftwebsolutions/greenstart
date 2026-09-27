@props([
    'label',
    'name',
    'existingUrl' => null,
    'removeName' => null,
    'hint' => 'JPG, PNG or WebP. The file uploads only when you save the form.',
    'wide' => false,
])

@php
    $removeName ??= 'remove_'.$name;
    $inputId = 'media-'.str_replace(['_', '.'], '-', $name);
@endphp

<div
    {{ $attributes }}
    x-data="{
        preview: @js($existingUrl),
        original: @js($existingUrl),
        selected: false,
        removed: false,
        objectUrl: null,
        choose(event) {
            const file = event.target.files?.[0];
            if (! file) return;
            if (this.objectUrl) URL.revokeObjectURL(this.objectUrl);
            this.objectUrl = URL.createObjectURL(file);
            this.preview = this.objectUrl;
            this.selected = true;
            this.removed = false;
        },
        clear() {
            this.$refs.file.value = '';
            if (this.objectUrl) URL.revokeObjectURL(this.objectUrl);
            this.objectUrl = null;
            this.preview = null;
            this.selected = false;
            this.removed = Boolean(this.original);
        },
        restore() {
            this.preview = this.original;
            this.selected = false;
            this.removed = false;
        }
    }"
>
    <label for="{{ $inputId }}" class="mb-1.5 block text-[12px] font-bold text-ink">{{ $label }}</label>
    <input
        x-ref="file"
        id="{{ $inputId }}"
        name="{{ $name }}"
        type="file"
        accept="image/jpeg,image/png,image/webp"
        @change="choose"
        class="block w-full rounded-lg border border-hairline-strong bg-white text-[11.5px] text-ink file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-2.5 file:text-xs file:font-semibold file:text-primary"
    >
    <input type="hidden" name="{{ $removeName }}" :value="removed ? '1' : '0'">
    <p class="mt-1.5 text-[10.5px] leading-relaxed text-ink-muted">{{ $hint }}</p>
    @error($name)<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror

    <div class="mt-3 overflow-hidden rounded-lg border border-hairline bg-[#fafbfc]">
        <div class="{{ $wide ? 'aspect-[16/6]' : 'aspect-[4/3]' }} grid place-items-center overflow-hidden">
            <img x-cloak x-show="preview" :src="preview" alt="{{ $label }} preview" class="h-full w-full object-cover">
            <div x-cloak x-show="! preview" class="px-4 text-center">
                <span class="mx-auto grid size-9 place-items-center rounded-lg bg-white text-ink-muted">{!! \Modules\SysAdmin\Support\Icon::get('image', 'h-4 w-4') !!}</span>
                <p class="mt-2 text-[10.5px] text-ink-muted">No image selected</p>
            </div>
        </div>
        <div class="flex items-center justify-between gap-2 border-t border-hairline bg-white px-3 py-2">
            <span class="min-w-0 truncate text-[10.5px] font-medium text-ink-muted" x-text="selected ? 'New preview · pending save' : (preview ? 'Current stored image' : (removed ? 'Removal pending save' : 'No image'))"></span>
            <div class="flex shrink-0 items-center gap-1">
                <button x-cloak x-show="original && ! preview" type="button" @click="restore" class="rounded-md px-2 py-1 text-[10.5px] font-semibold text-primary hover:bg-primary-50">Restore</button>
                <button x-cloak x-show="preview" type="button" @click="clear" class="rounded-md px-2 py-1 text-[10.5px] font-semibold text-red-600 hover:bg-red-50">Remove</button>
            </div>
        </div>
    </div>
</div>
