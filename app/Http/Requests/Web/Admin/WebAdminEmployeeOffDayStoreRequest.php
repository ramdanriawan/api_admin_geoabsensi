<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WebAdminEmployeeOffDayStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('web.admin.employeeOffDay.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', Rule::unique('employee_offdays')->where(function ($query) {
                return $query->where('employee_id', $this->employee_id);
            })->where(function ($query) {
                return $query->where('off_type_id', $this->off_type_id);
            })],
        ];
    }
}
