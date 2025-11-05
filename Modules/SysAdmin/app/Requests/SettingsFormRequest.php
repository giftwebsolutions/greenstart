<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\Page;

class SettingsFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return match (request()->route()->action['as']) {
            'sysadmin.settings.create',  => $this->store(),
            'sysadmin.settings.edit' => $this->update(),
            'sysadmin.settings.ajax-store' => $this->update(),
            default => $this->store()
        };
    }


    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store()
    {
        return [
            'key' => 'required|string|max:30|unique:settings',
            'value' => 'required|string',
            'type' => 'required|string'
        ];
    }

    /**
     * Get the validation rules that apply to the put/patch request.
     *
     * @return array
     */
    public function update()
    {
        return [
            'key' => 'required|string|max:30|unique:settings,key,' . $this->id,
            'value' => 'required|string',
            'type' => 'required|string'
        ];
    }
}
