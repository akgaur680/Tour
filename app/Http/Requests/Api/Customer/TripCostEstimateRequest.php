<?php

namespace App\Http\Requests\Api\Customer;

use Illuminate\Foundation\Http\FormRequest;

class TripCostEstimateRequest extends FormRequest
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
            'from_address' => ['required', 'string','regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/'],
            'to_address' => ['required_if:trip_type,round-trip,one-way,airport', 'string', 'regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/', 'different:from_address'],
            'trip_type' => ['required', 'string', 'exists:trip_types,slug'],
            'return_date' => ['required_if:trip_type,round-trip', 'date'],
            'pickup_date' => ['required', 'date'],
            'pickup_time' => ['required', 'date_format:H:i'], 
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
        ];
    }
}
