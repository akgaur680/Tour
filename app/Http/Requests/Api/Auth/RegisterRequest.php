<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:2048'],
            'email' => ['required', 'email', 'max:255'],
            'mobile_no' => ['required', 'integer', 'min:0'],
            'role' => ['required', 'in:driver,customer']
        ];
    }
}
