@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Edit Attribute Type</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Catalog</li>
    <li class="breadcrumb-item">Attributes</li>
    <li class="breadcrumb-item active">Types</li>
@endsection

@section('content')
<div class="container-fluid">
    @if ($errors->any())
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <form class="theme-form" id="update-attribute-type" method="POST"
                      action="{{ route('sysadmin.catalog.attribute.type.update', $type->attribute_type_id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="card-body p-3">

                        <div class="mb-3">
                            <label for="type_name" class="col-form-label">Type Name</label>
                            <input id="type_name" type="text" name="type_name"
                                   value="{{ old('type_name', $type->type_name) }}"
                                   class="form-control @error('type_name') is-invalid @enderror" required>
                            @error('type_name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="identifier" class="col-form-label">Identifier <small class="text-muted">(optional)</small></label>
                            <input id="identifier" type="text" name="identifier"
                                   value="{{ old('identifier', $type->identifier) }}"
                                   class="form-control @error('identifier') is-invalid @enderror">
                            @error('identifier') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('sysadmin.catalog.attribute.type.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary mx-2">Update</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar: Status --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-3">
                    <label class="col-form-label">Status</label>
                </div>
                <div class="card-body p-3">
                    @php
                        $statuses = $statuses ?? [0=>'Delete',1=>'Published',2=>'Draft'];
                    @endphp
                    <select class="form-select @error('status') is-invalid @enderror"
                            name="status" form="update-attribute-type" required>
                        <option value="">Select one</option>
                        @foreach($statuses as $k => $v)
                            <option value="{{ $k }}" {{ (string)old('status', $type->status)===(string)$k ? 'selected' : '' }}>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\AttributeTypeFormRequest', '#update-attribute-type') !!}
@endPushOnce
