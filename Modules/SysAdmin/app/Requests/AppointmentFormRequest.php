<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\EnquiryAppointment;

class AppointmentFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'enquiry_id' => ['nullable', 'integer', Rule::exists('enquiries', 'id')],
            'assigned_to' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'title' => ['required', 'string', 'max:150'],
            'customer_name' => ['required', 'string', 'max:120'],
            'mobile' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
            'meeting_type' => ['required', Rule::in(array_keys(EnquiryAppointment::$meetingTypes))],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys(EnquiryAppointment::$statuses))],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
