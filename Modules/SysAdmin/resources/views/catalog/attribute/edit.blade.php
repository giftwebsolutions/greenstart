@extends('sysadmin::layouts.master')

@section('breadcrumb-title')<h3>Edit Attribute</h3>@endsection
@section('breadcrumb-items')<li class="breadcrumb-item">Catalog</li><li class="breadcrumb-item">Attributes</li><li class="breadcrumb-item active">Edit</li>@endsection

@section('content')
    <div class="container-fluid"><livewire:sysadmin.catalog.attributes.form :id="$id" /></div>
@endsection
