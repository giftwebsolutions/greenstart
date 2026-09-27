@extends('sysadmin::layouts.master')

@section('breadcrumb-title')<h3>Family Builder</h3>@endsection
@section('breadcrumb-items')<li class="breadcrumb-item">Catalog</li><li class="breadcrumb-item">Attribute Families</li><li class="breadcrumb-item active">Builder</li>@endsection

@section('content')
    <div class="container-fluid"><livewire:sysadmin.catalog.families.builder :id="$id" /></div>
@endsection
