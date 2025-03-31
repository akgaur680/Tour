<?php

namespace App\Http\Requests\Api\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookATripRequest extends FormRequest
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
            'from_address' => ['required', 'string','regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/', 'different:to_address' ,'required_if:to_airport,true'],
            'to_address' => ['required_if:trip_type,round-trip,one-way,airport', 'string', 'required_if:from_airport,true', 'regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/', 'different:from_address'],
            'trip_type' => ['required', 'string', 'exists:trip_types,slug'],
            'return_date' => ['required_if:trip_type,round-trip', 'date'],
            'pickup_date' => ['required', 'date'],
            'pickup_time' => ['required', 'date_format:H:i'],
            'airport_location' => ['required_if:trip_type,airport', 'string', 'regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/'],
            'from_airport' => ['required_if:trip_type,airport', 'boolean'],
            'to_airport' => ['required_if:trip_type,airport', 'boolean'],
            'customer_name' => ['required', 'string'],
            'customer_email' => ['required', 'email'],
            'customer_phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'],
            'pickup_location' => ['required_if:trip_type,one-way,local,round-trip', 'string'],
            'drop_location' => ['required_if:trip_type,one-way', 'string' ,'required_if:from_airport,true'],
            'car_id' => ['required', 'exists:cars,id'],
            'driver_id' => ['required', 'exists:users,id'],
            'total_distance' => ['required', 'string'],
            'total_hours' => ['required_if:trip_type,local', 'numeric', 'min:1'],
            'original_amount' => ['required', 'numeric', 'min:1'],
            'is_chauffeur_needed' => ['required', 'boolean'],
            'chauffeur_price' => ['required_if:is_chauffeur_needed,true', 'numeric', 'min:1'],
            'preffered_chauffeur_language' => ['required_if:is_chauffeur_needed,true', 'in:Hindi,English'],
            'is_new_car_promised' => ['required', 'boolean'],
            'new_car_price' => ['required_if:is_new_car_promised,true', 'numeric', 'min:1'],
            'is_cab_luggage_needed' => ['required', 'boolean'],
            'cab_luggage_price' => ['required_if:is_cab_luggage_needed,true', 'numeric', 'min:1'],
            'is_diesel_car_needed' => ['required', 'boolean'  , Rule::prohibitedIf($this->is_new_car_promised == true) ],
            'diesel_car_price' => ['required_if:is_diesel_car_needed,true', 'numeric', 'min:1'],
            'payment_type' => ['required', 'string', 'in:Half Payment,Partial Payment,Full Payment,Pay on Delivery'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'trip_type.exists' => 'The selected trip type is invalid. Please select a valid trip type. (one-way, round-trip, airport, local)',
            'return_date.required_if' => 'Return date is required for round-trip.',
            'to_address.required_if' => 'Destination address is required for this trip type.',
            'from_address.regex' => 'The from address must be in "CityName, StateName" format.',
            'to_address.regex' => 'The to address must be in "CityName, StateName" format.',
            'total_hours.required_if' => 'Total hours is required for local trips.',
            'car_id.exists' => 'The selected car is invalid. Please select a valid car.',
            'payment_type.in' => 'The selected payment type is invalid. Please select a valid payment type.',
            'is_diesel_car_needed.prohibited_if' => 'Due to the new government policy, a new car cannot be a diesel car. Please select either a new car or a diesel car, but not both.',
        ];
    }

}
