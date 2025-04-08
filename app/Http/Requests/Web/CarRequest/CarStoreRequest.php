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
            'car_type' => ['required', 'string', 'max:2048'],
            'seats' => ['required', 'integer'],
            'ac' => ['required', 'boolean'],
            'luggage_limit' => ['required', 'integer'],
            'price_per_km' => ['required', 'integer'],
            'price_per_hour' => ['required', 'decimal:0,2'],
            'car_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,avif,web.p', 'max:2048'],
            'trip_type_ids' => ['required', 'array'],
        ];
    }
}
