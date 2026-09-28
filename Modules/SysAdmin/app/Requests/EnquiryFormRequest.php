<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\Enquiry;

class EnquiryFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email:rfc', 'max:75'],
            'mobile' => ['required', 'string', 'max:15'],
            'city' => ['nullable', 'string', 'max:180'],
            'state' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:255'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
            'category_id' => ['nullable', 'integer', Rule::exists('product_category', 'id')],
            'product_id' => [
                'nullable',
                'integer',
                Rule::exists('product', 'id')->where(fn ($query) => filled($this->input('category_id'))
                    ? $query->where('product_category', $this->integer('category_id'))
                    : $query),
            ],
            'qty' => ['nullable', 'numeric', 'min:0.01', 'max:99999999.99'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'req_price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'status' => ['required', 'integer', Rule::in(array_keys(Enquiry::$statuses))],
            'priority' => ['required', Rule::in(array_keys(Enquiry::$priorities))],
            'assigned_to' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'enquiry_type' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'customer name',
            'mobile' => 'mobile number',
            'email' => 'email address',
            'category_id' => 'product category',
            'product_id' => 'product',
            'req_price' => 'requested price',
            'assigned_to' => 'assigned team member',
        ];
    }

    protected function prepareForValidation(): void
    {
        $trimmed = [];
        foreach (['name', 'email', 'mobile', 'city', 'state', 'subject', 'message', 'internal_notes', 'enquiry_type'] as $field) {
            if (is_string($this->input($field))) {
                $trimmed[$field] = trim($this->input($field));
            }
        }

        $this->merge([
            ...$trimmed,
            'status' => $this->input('status', Enquiry::STATUS_NEW),
            'priority' => $this->input('priority', 'normal'),
        ]);
    }
}
