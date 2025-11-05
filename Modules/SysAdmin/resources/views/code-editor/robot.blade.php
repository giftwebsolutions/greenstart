@extends('sysadmin::layouts.master')

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Edit Robot Txt File</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Editor</li>
    <li class="breadcrumb-item active">robot.txt</li>
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
            <div class="col-md-12">
                <div class="card">
                    <form class="theme-form" id="create-department" method="POST" enctype="multipart/form-data"
                        action="{{ route('sysadmin.code.robot-save') }}">
                        @csrf

                        <div class="card-body p-3">
                            <div class="form-group">
                                <label for="content">File content:</label>
                                <textarea name="content" id="code-editor">{{ $content }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="javascript:void(0);" id="cancel-button" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                        </div>
                </div>
            </div>


            </form>
        </div>
    </div>
@endsection
@pushOnce('scripts')
    <script type="module">
        var editor = CodeMirror.fromTextArea(document.getElementById("code-editor"), {
            lineNumbers: true,
            mode: "xml", // Change the mode as per your requirement
            theme: "dracula",
            autoCloseBrackets: true,
            matchBrackets: true,
            viewportMargin: Infinity
        });
        editor.setSize(null, "500px");
    </script>
@endPushOnce
