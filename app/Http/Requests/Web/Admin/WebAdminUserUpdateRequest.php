<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WebAdminUserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('web.admin.user.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validation = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->post('email') . ',email',
        ];

        if ($this->post('password')) {
            $validation = [
                ...$validation,
                'password' => 'required|min:6|confirmed',
            ];
        }

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->post('email') . ',email',
        ];
    }
}
