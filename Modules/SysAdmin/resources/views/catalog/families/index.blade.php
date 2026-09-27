@extends('sysadmin::layouts.master')

@section('breadcrumb-title')<h3>Attribute Families</h3>@endsection
@section('breadcrumb-items')<li class="breadcrumb-item">Catalog</li><li class="breadcrumb-item active">Attribute Families</li>@endsection

@section('content')
    <div class="container-fluid"><livewire:sysadmin.catalog.families.index /></div>
@endsection
