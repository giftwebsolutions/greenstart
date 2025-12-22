@extends('sysadmin::layouts.master')
@section('title', 'Home Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row widget-grid">

            {{-- Welcome Box --}}
            <div class="col-12 box-col-12">
                <div class="card profile-box">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <div class="greeting-user">
                                    <h4 class="f-w-600">Welcome to</h4>
                                    <p>Green Star</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Left Section --}}
            <div class="col-8">
                <div class="row">

                    {{-- Manage Products Page --}}
                    <div class="col-xl-12 col-sm-6 mb-3">
                        <a href="{{ route('sysadmin.catalog.product.index') }}"
                            style="text-decoration:none; color:inherit;">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round primary">
                                            <div class="bg-round">
                                                <svg class="svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#tag') }}"></use>
                                                </svg>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Manage Products Page</h4>
                                            <span class="f-light">Catalog > Manage Products</span>
                                        </div>
                                    </div>
                                    <div class="font-primary f-w-500">
                                        <i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Manage CMS Pages --}}
                    <div class="col-xl-12 col-sm-6 mb-3">
                        <a href="{{ route('sysadmin.cms.page.index') }}" style="text-decoration:none; color:inherit;">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <svg class="svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#return-box') }}"></use>
                                                </svg>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Manage CMS Page</h4>
                                            <span class="f-light">CMS Page > Manage Page</span>
                                        </div>
                                    </div>
                                    <div class="font-warning f-w-500">
                                        <i class="icon-arrow-down icon-rotate me-1"></i><span>-20%</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Settings --}}
                    <div class="col-xl-12 col-sm-6 mb-3">
                        <a href="{{ route('sysadmin.settings.index') }}" style="text-decoration:none; color:inherit;">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round success">
                                            <div class="bg-round">
                                                <svg class="svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#rate') }}"></use>
                                                </svg>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Settings</h4>
                                            <span class="f-light">Add, Edit Site Settings</span>
                                        </div>
                                    </div>
                                    <div class="font-success f-w-500">
                                        <i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Blog --}}
                    <div class="col-xl-12 col-sm-6 mb-3">
                        <a href="{{ route('sysadmin.blog.index') }}" style="text-decoration:none; color:inherit;">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round success">
                                            <div class="bg-round">
                                                <svg class="svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#rate') }}"></use>
                                                </svg>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Blogs</h4>
                                            <span class="f-light">Add New Post</span>
                                        </div>
                                    </div>
                                    <div class="font-success f-w-500">
                                        <i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Attribute Page --}}
                    <div class="col-xl-12 col-sm-6 mb-3">
                        <a href="{{ route('sysadmin.catalog.attribute.index') }}"
                            style="text-decoration:none; color:inherit;">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round secondary">
                                            <div class="bg-round">
                                                <svg class="svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#cart') }}"></use>
                                                </svg>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Attributes Page</h4>
                                            <span class="f-light">Manage Attributes</span>
                                        </div>
                                    </div>
                                    <div class="font-secondary f-w-500">
                                        <i class="icon-arrow-up icon-rotate me-1"></i><span>+50%</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

            {{-- Right Sidebar Activity Log --}}
            <div class="col-4">
                <x-sysadmin::activitylog />
            </div>

        </div>
    </div>
@endsection

@section('script')
@endsection