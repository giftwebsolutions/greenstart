@props(['align' => 'left'])
<th {{ $attributes->merge(['class' => 'border-b border-hairline bg-[#fafbfc] px-4 py-3 text-'.$align.' text-[11.5px] font-bold uppercase tracking-wide text-ink-muted']) }}>{{ $slot }}</th>
