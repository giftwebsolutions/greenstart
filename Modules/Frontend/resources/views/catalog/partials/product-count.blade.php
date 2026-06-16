@php
    $from = $products->firstItem() ?? 0;
    $to = $products->lastItem() ?? 0;
    $total = $products->total();
    $lastPage = $products->lastPage();
@endphp

Showing {{ $from }} to {{ $to }} of {{ $total }} ({{ $lastPage }} {{ $lastPage === 1 ? 'Page' : 'Pages' }})
