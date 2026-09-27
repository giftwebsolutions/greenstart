@extends('sysadmin::layouts.master')

@section('breadcrumb-title')<h3>Attributes</h3>@endsection
@section('breadcrumb-items')<li class="breadcrumb-item">Catalog</li><li class="breadcrumb-item active">Attributes</li>@endsection

@section('content')
    <div class="container-fluid"><livewire:sysadmin.catalog.attributes.index /></div>
@endsection
