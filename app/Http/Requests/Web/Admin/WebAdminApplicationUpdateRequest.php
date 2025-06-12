<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WebAdminApplicationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('web.admin.application.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'version' => ['required', 'regex:/^\d+(\.\d+){0,2}(-[a-z0-9]+)?$/i', 'max:15'], // contoh: 1, 1.0, 1.0.3-beta
            'name' => ['required', 'string', 'max:40'],
            'phone' => ['required', 'regex:/^\+?[0-9]{8,15}$/'], // support +62 atau 0812xxx
            'email' => ['required', 'email', 'max:80'],
            'developer_name' => ['required', 'string', 'max:40'],
            'brand' => ['required', 'string', 'max:30'],
            'website' => ['required', 'url', 'max:100'],
            'release_date' => ['required', 'date', 'before_or_equal:today'],
            'last_update' => ['required', 'date', 'after_or_equal:release_date', 'before_or_equal:today'],
            'terms_url' => ['required', 'url', 'max:100'],
            'privacy_policy_url' => ['required', 'url', 'max:100'],
            'maximum_radius_in_meters' => ['required', 'integer', 'min:30', 'max:10000'], // Batas logis
            'is_active' => ['required', 'in:1,0'],
        ];
    }
}
