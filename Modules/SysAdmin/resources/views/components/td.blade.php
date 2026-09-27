@props(['align' => 'left'])
<td {{ $attributes->merge(['class' => 'border-b border-hairline px-4 py-3 text-'.$align]) }}>{{ $slot }}</td>
