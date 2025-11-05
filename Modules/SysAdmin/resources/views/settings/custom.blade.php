@extends('sysadmin::layouts.master')
@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Settings</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script type="module">
            $(document).ready(function() {

                $('form input').keydown(function(e) {
                    if (e.keyCode == 13) {
                        var inputs = $(this).parents("form").eq(0).find(":input");
                        if (inputs[inputs.index(this) + 1] != null) {
                            inputs[inputs.index(this) + 1].focus();
                        }
                        e.preventDefault();
                        return false;
                    }
                });

                $('#add-new').on("click", function() {
                    $('.customizer-body').empty();
                    $(".customizer-contain").addClass("open");
                    var url = $(this).attr('data-url');
                    if (url != 'undefined') {
                        var title = $(this).attr('data-title');
                        $.get(url, function(data) {
                            $('h5#customizer-title').html(title);
                            $('.customizer-body').html(data);
                        });
                    }
                });

                $('#settings-table').on("click", '#ajax-edit', function() {
                    $('.customizer-body').empty();
                    $(".customizer-contain").addClass("open");
                    var url = $(this).attr('data-url');
                    if (url != 'undefined') {
                        var title = $(this).attr('data-title');
                        $.get(url, function(data) {
                            $('h5#customizer-title').html(title);
                            $('.customizer-body').html(data);
                        });
                    }
                });

                $('#settings-table').on("click", '#ajax-view', function() {
                    $('.customizer-body').empty();
                    $(".customizer-contain").addClass("open");
                    var url = $(this).attr('data-url');
                    if (url != 'undefined') {
                        var title = $(this).attr('data-title');
                        $.get(url, function(data) {
                            $('h5#customizer-title').html(title);
                            $('.customizer-body').html(data);
                        });
                    }
                });


                $(".customizer-contain .icon-close").on('click', function() {
                    $(".customizer-contain").removeClass("open");
                });

            });
        </script>
        {!! JsValidator::formRequest('Modules\SysAdmin\Requests\SettingsFormRequest', '#settings-new') !!}
    @endpush
@endsection

@section('script')
@endsection
