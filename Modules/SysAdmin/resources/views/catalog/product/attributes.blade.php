@extends('sysadmin::layouts.master')

@section('content')
    <livewire:sysadmin.catalog.products.attribute-editor :product-id="$product->id" />
@endsection
