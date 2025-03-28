<?php

namespace App\Http\Requests\Web\CarRequest;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CarStoreRequest extends BaseRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'car_number' => ['required', 'string', 'min:6', 'max:12'],
            'car_model' => ['required', 'integer'],
            'car_type' => ['required', 'string', 'min:4', 'max:2048'],
            'seats' => ['required', 'integer', 'min:1', 'max:10'],
            'ac' => ['required', 'boolean'],
            'luggage_limit' => ['required', 'integer', 'min:1', 'max:10'],
            'price_per_km' => ['required', 'integer', 'min:1', 'max:10'],
            'car_image' => ['nullable','image', 'mimes:jpeg,png,jpg,avif', 'max:2048'],
        ];
    }
}
