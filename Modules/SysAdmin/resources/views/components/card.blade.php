@props(['padded' => false])
<div {{ $attributes->class(['rounded-xl border border-hairline bg-white shadow-sm', 'p-4 lg:p-5' => $padded]) }}>{{ $slot }}</div>
