<?php

namespace App\Http\Requests\Api\Driver\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:2048'],
            'email' => ['required', 'email', 'max:255' , 'unique:users'],
            'role' => ['required', 'in:driver'],
            'mobile_no' => ['required', 'integer', 'digits:10'],
            'adhar_card_image' => ['required','image', 'mimes:jpeg,png,jpg,avif', 'max:2048'],
            
        ];
    }
    // return [
    //     'name' => ['required', 'string', 'max:2048'],
    //     'email' => ['required', 'email', 'max:255' , 'unique:users'],
    //     'role' => ['required', 'in:driver'],
    //     'mobile_no' => ['required', 'integer', 'digits:10'],
    //     'car_number' => ['required', 'string', 'max:2048' , 'unique:cars,car_number'],
    //     'car_model' => ['required', 'string', 'max:2048'],
    //     'car_type' => ['required', 'string', 'min:4', 'max:2048'],
    //     'seats' => ['required', 'integer', 'min:1', 'max:10'],
    //     'ac' => ['required', 'boolean'],
    //     'luggage_limit' => ['required', 'integer', 'min:1', 'max:10'],
    //     'price_per_km' => ['required', 'integer', 'min:1', 'max:10'],
    //     'price_per_hour' => ['required', 'integer', 'min:1', 'max:10'],
    //     'car_image' => ['nullable','image', 'mimes:jpeg,png,jpg,avif', 'max:2048'],
    // ];
}
