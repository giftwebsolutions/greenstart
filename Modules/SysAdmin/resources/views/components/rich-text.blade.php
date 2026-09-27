@props([
    'label',
    'model',
    'required' => false,
    'hint' => null,
])

<div
    {{ $attributes }}
    wire:key="rich-text-{{ str_replace(['.', ' '], '-', $model) }}"
    x-data="{ value: $wire.entangle(@js($model)) }"
    x-init="$refs.editor.innerHTML = value || ''"
>
    <label class="mb-1.5 block text-[12.5px] font-bold text-ink">{{ $label }} @if($required)<span class="text-red-600">*</span>@endif</label>
    <div class="html-editor-shell">
        <div class="html-editor-toolbar" role="toolbar" aria-label="Text formatting">
            <button type="button" title="Bold" @click.prevent="document.execCommand('bold')"><strong>B</strong></button>
            <button type="button" title="Italic" @click.prevent="document.execCommand('italic')"><em>I</em></button>
            <button type="button" title="Underline" @click.prevent="document.execCommand('underline')"><u>U</u></button>
            <span></span>
            <button type="button" title="Heading" @click.prevent="document.execCommand('formatBlock', false, 'h3')">H3</button>
            <button type="button" title="Paragraph" @click.prevent="document.execCommand('formatBlock', false, 'p')">P</button>
            <span></span>
            <button type="button" title="Bulleted list" @click.prevent="document.execCommand('insertUnorderedList')">• List</button>
            <button type="button" title="Numbered list" @click.prevent="document.execCommand('insertOrderedList')">1. List</button>
            <button type="button" title="Link" @click.prevent="const url = prompt('Link URL'); if (url) document.execCommand('createLink', false, url)">Link</button>
            <button type="button" title="Remove formatting" @click.prevent="document.execCommand('removeFormat')">Clear</button>
        </div>
        <div x-ref="editor" wire:ignore contenteditable="true" role="textbox" aria-multiline="true" class="html-editor-surface" @input.debounce.250ms="value = $refs.editor.innerHTML"></div>
    </div>
    @if($hint)<p class="mt-1.5 text-[11px] text-ink-muted">{{ $hint }}</p>@endif
    @error($model)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
