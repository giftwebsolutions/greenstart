<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\Enquiry;

class EnquiryFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Determine validation rules based on route name.
     */
    public function rules()
    {
        return match (request()->route()->action['as'] ?? null) {

            'sysadmin.enquiry.create',
            'sysadmin.enquiry.store' => $this->store(),

            'sysadmin.enquiry.edit',
            'sysadmin.enquiry.update' => $this->update(),

            default => $this->store(),
        };
    }

    /**
     * Validation for create
     */
    public function store()
    {
        return [
            'name'        => ['required', 'string', 'max:50'],
            'mobile'      => ['required', 'string', 'max:15'],
            'email'       => ['nullable', 'email', 'max:75'],

            'city'        => ['nullable', 'string', 'max:50'],
            'state'       => ['nullable', 'string', 'max:50'],

            'message'     => ['required', 'string'],

            'category_id' => ['nullable', 'integer'],
            'product_id'  => ['nullable', 'integer'],

            'qty'         => ['required', 'numeric', 'min:0.01'],
            'price'       => ['required', 'numeric', 'min:0'],
            'req_price'   => ['nullable', 'numeric', 'min:0'],

            'status'      => [
                'required',
                Rule::in(array_keys((new Enquiry)->statuses ?? [0 => 'Inactive', 1 => 'Active']))
            ],
        ];
    }

    /**
     * Validation for update
     */
    public function update()
    {
        return [
            'name'        => ['required', 'string', 'max:50'],
            'mobile'      => ['required', 'string', 'max:15'],
            'email'       => ['nullable', 'email', 'max:75'],

            'city'        => ['nullable', 'string', 'max:50'],
            'state'       => ['nullable', 'string', 'max:50'],

            'message'     => ['required', 'string'],

            'category_id' => ['nullable', 'integer'],
            'product_id'  => ['nullable', 'integer'],

            'qty'         => ['required', 'numeric', 'min:0.01'],
            'price'       => ['required', 'numeric', 'min:0'],
            'req_price'   => ['nullable', 'numeric', 'min:0'],

            'status'      => [
                'required',
                Rule::in(array_keys((new Enquiry)->statuses ?? [0 => 'Inactive', 1 => 'Active']))
            ],
        ];
    }

    /**
     * Custom attribute names (clean error messages)
     */
    public function attributes()
    {
        return [
            'name'        => 'customer name',
            'mobile'      => 'mobile number',
            'email'       => 'email address',
            'city'        => 'city',
            'state'       => 'state',
            'message'     => 'message',
            'category_id' => 'category',
            'product_id'  => 'product',
            'qty'         => 'quantity',
            'price'       => 'price',
            'req_price'   => 'requested price',
            'status'      => 'status',
        ];
    }
}
