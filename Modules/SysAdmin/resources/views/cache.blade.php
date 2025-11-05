@extends('sysadmin::layouts.master')
@section('title', 'Cache Management')

@section('css')
@endsection

@section('style')

@endsection

@section('breadcrumb-title')
    <h3>Cache Management</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Caches</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row widget-grid">
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#moon') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"> </use>
                                    </svg>
                                </div>
                            </div>
                            <div id="route-cache">
                                <h4>Route</h4><span class="f-light">Cache</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round primary">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#moon') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"> </use>
                                    </svg>
                                </div>
                            </div>
                            <div id="config-cache">
                                <h4>Config</h4><span class="f-light">Cache</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">

                        <div class="widget-content">
                            <div class="widget-round warning">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#moon') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"> </use>
                                    </svg>
                                </div>
                            </div>
                            <div id="file-cache">
                                <h4>File</h4><span class="f-light">Cache</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round success">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#moon') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"> </use>
                                    </svg>
                                </div>
                            </div>
                            <div id="optimize-cache">
                                <h4>Optimize</h4><span class="f-light">Clear</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@pushOnce('scripts')
    <script type="module">
        $('div#route-cache').click(function() {
            $.get("{{route('cache.route')}}", function(data) {
                alert("Route Cache Cleared.");
            });
        });

         $('div#optimize-cache').click(function() {
            $.get("{{route('cache.optimize')}}", function(data) {
                alert("Optimize Clear Done.");
            });
        });

         $('div#file-cache').click(function() {
            $.get("{{route('cache.file')}}", function(data) {
                alert("View Files are Cleared.");
            });
        });

         $('div#config-cache').click(function() {
            $.get("{{route('cache.config')}}", function(data) {
                alert("Config Cache Cleared.");
            });
        });
    </script>
@endPushOnce
@section('script')

@endsection
