<?php

namespace App\Http\Requests\Web\PricingRequest;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddPricingRequest extends BaseRequest
{
  
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_type_id' => ['required', 'exists:trip_types,id'],
            'origin_city_id' => [
                'nullable',
                'required_if:trip_type_id,1',  // Required for One-Way
                // 'required_if:trip_type_id,4,airport_type,to_airport',  // Required for Airport Drop
                'required_if:airport_type,to_airport,trip_type_id,4',
                'exists:cities,id'
            ],
            'destination_city_id' => [
                'nullable',
                'required_if:trip_type_id,1',  // Required for One-Way
                // 'required_if:trip_type_id,4,airport_type,from_airport',  // Required ONLY for Airport Pickup
                'required_if:airport_type,from_airport,trip_type_id,4',
                'exists:cities,id'
            ],
            'origin_state_id'=> [
                'nullable',
                'required_if:trip_type_id,1',  // Required for One-Way
                // 'required_if:trip_type_id,4,airport_type,to_airport',  // Required for Airport Drop
                'required_if:airport_type,to_airport,trip_type_id,4',

                'exists:states,id'
            ],
            'destination_state_id' => [
                'nullable',
                'required_if:trip_type_id,1',  // Required for One-Way
                // 'required_if:trip_type_id,4,airport_type,from_airport',  // Required ONLY for Airport Pickup
                'required_if:airport_type,from_airport,trip_type_id,4',
                'exists:states,id'
            ],
            'airport_id' => [
                'nullable',
                'required_if:trip_type_id,4',
                'exists:airports,id'
            ],
            'car_id' => ['required', 'exists:cars,id'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
    
}
