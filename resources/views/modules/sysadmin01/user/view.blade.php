@extends('sysadmin::layouts.master')
@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>User Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item active">View</li>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card p-2">
                    <div class="card-header">
                        <a href="{{ route('sysadmin.user.index') }}" class="btn btn-primary mx-2">Back</a>
                        <a href="{{ route('sysadmin.user.edit', $user['id']) }}" class="btn btn-secondary mx-2">Update</a>
                        <a href="{{ route('sysadmin.user.delete', $user['id']) }}" class="btn btn-danger mx-2">Delete</a>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                @foreach ($user as $key => $value)
                                    <tr class="">
                                        <td scope="row">{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
