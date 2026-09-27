<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlockFormRequest extends FormRequest
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
        return $this->isMethod('PATCH') || $this->isMethod('PUT')
            ? $this->update()
            : $this->store();
    }

    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store()
    {
        return [
            'key' => ['required', 'string', 'max:30', 'unique:blocks,key'],
            'title' => ['required', 'string', 'max:120'],
            'value' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
            'remove_thumbnail' => ['nullable', 'boolean'],
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
            'key' => ['required', 'string', 'max:30', Rule::unique('blocks', 'key')->ignore($this->route('id'))],
            'title' => ['required', 'string', 'max:120'],
            'value' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
            'remove_thumbnail' => ['nullable', 'boolean'],
        ];
    }
}
