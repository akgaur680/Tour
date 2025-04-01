<?php

namespace App\Http\Requests\Web\DriverRequest;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DriverStoreRequest extends BaseRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'mobile_no' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'address' => ['required', 'string'],
            'profile_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'car_id' => ['required', 'exists:cars,id'],
            'driving_license' => ['required', 'string', Rule::unique('drivers', 'driving_license')->ignore($this->id)],
            'license_expiry' => ['required', 'date', 'after:today'],
            'license_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'adhaar_number' => ['required', 'string', Rule::unique('drivers', 'adhaar_number')->ignore($this->id)],
            'adhaar_image_front' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'adhaar_image_back' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_approved' => ['boolean'],
            'is_available' => ['boolean'],
        ];
        
    }
}
