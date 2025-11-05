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
            <div class="col-12 box-col-12">
                <div class="card profile-box">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <div class="greeting-user">
                                    <h4 class="f-w-600">Welcome to</h4>
                                    <p>Adhi Parasakthi Hospitals</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round secondary">
                                            <div class="bg-round">
                                                <svg class="svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#cart') }}"> </use>
                                                </svg>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Departments</h4><span class="f-light">
                                                <a href="{{ route('sysadmin.departments.index') }}"> Manage
                                                    Department</a></span>
                                        </div>
                                    </div>
                                    <div class="font-secondary f-w-500"><i
                                            class="icon-arrow-up icon-rotate me-1"></i><span>+50%</span></div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card widget-1">
                                    <div class="card-body">
                                        <div class="widget-content">
                                            <div class="widget-round primary">
                                                <div class="bg-round">
                                                    <svg class="svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#tag') }}"> </use>
                                                    </svg>
                                                    <svg class="half-circle svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h4>Doctors Profile</h4><span class="f-light">
                                                    <a href="{{ route('sysadmin.doctor.index') }}"> Manage Doctor's
                                                        Entries</a></span>
                                            </div>
                                        </div>
                                        <div class="font-primary f-w-500"><i
                                                class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round">
                                                <svg class="svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#return-box') }}"> </use>
                                                </svg>
                                                <svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>CMS Pages</h4><span class="f-light">

                                                <a href="{{ route('sysadmin.page.index') }}"> Manage CMS Pages</a></span>
                                        </div>
                                    </div>
                                    <div class="font-warning f-w-500"><i
                                            class="icon-arrow-down icon-rotate me-1"></i><span>-20%</span></div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card widget-1">
                                    <div class="card-body">
                                        <div class="widget-content">
                                            <div class="widget-round success">
                                                <div class="bg-round">
                                                    <svg class="svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#rate') }}"> </use>
                                                    </svg>
                                                    <svg class="half-circle svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h4>Settings</h4><span class="f-light">
                                                    <a href="{{ route('sysadmin.settings.index') }}"> Add, Edit Site
                                                        Settings</a></span>
                                            </div>
                                        </div>
                                        <div class="font-success f-w-500"><i
                                                class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card widget-1">
                                    <div class="card-body">
                                        <div class="widget-content">
                                            <div class="widget-round success">
                                                <div class="bg-round">
                                                    <svg class="svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#rate') }}"> </use>
                                                    </svg>
                                                    <svg class="half-circle svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h4>Blogs</h4><span class="f-light">
                                                    <a href="{{ route('sysadmin.blog.create') }}"> Add New Post</a></span>
                                            </div>
                                        </div>
                                        <div class="font-success f-w-500"><i
                                                class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <x-sysadmin::activitylog />
            </div>

        </div>
    </div>
    </div>
@endsection

@section('script')
@endsection
