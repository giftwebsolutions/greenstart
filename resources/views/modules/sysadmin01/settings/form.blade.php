<form class="theme-form" id="settings-new" action="{{ route('sysadmin.settings.ajax-store', ['id' => $id]) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12 mb-4">
            <div class="mb-3">
                <label for="" class="form-label">Key</label>
                <input type="text" name="key" id="key" class="form-control"
                    value="{{ $id == 0 ? '' : $setting['key'] }}" placeholder="Facebook Page Link .." required />
                @error('key')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Value</label>
                <input type="text" name="value" id="value" class="form-control"
                    value="{{ $id == 0 ? '' : $setting['value'] }}" placeholder="https://www.facebook.com/" required />
                @error('value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <select class="form-select" name="type" id="type">
                    <option>Select Type</option>
                    @foreach ($types as $key => $value)
                        <option value="{{ $key }}"
                            {{ $key == ($id == 0 ? 0 : $setting['type']) ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="javascript:void(0);" id="cancel-button" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
@pushOnce('scripts')
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\SettingsFormRequest', '#settings-new') !!}
    <script type="module">
        $('a#cancel-button').click(function() {
            $(".customizer-contain").removeClass("open");
        });
    </script>
@endPushOnce
