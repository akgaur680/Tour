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
            'from_address' => ['required_if:trip_type,round-trip,one-way', 'required_if:to_airport,true', 'string', 'regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/' , 'different:to_address'],
            'to_address' => ['required_if:trip_type,round-trip,one-way,airport', 'required_if:from_airport,true', 'string', 'regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/', 'different:from_address'],
            'airport_location' => ['required_if:trip_type,airport', 'string', 'regex:/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/'],
            'from_airport' => ['required_if:trip_type,airport', 'boolean'],
            'to_airport' => ['required_if:trip_type,airport', 'boolean'],
            'trip_type' => ['required', 'string', 'exists:trip_types,slug'],
            'total_hours' => ['required_if:trip_type,local', 'numeric', 'min:1'],
            'return_date' => ['required_if:trip_type,round-trip', 'date', 'after:pickup_date'],
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
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
            'total_hours.required_if' => 'Total hours is required for local trips.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->trip_type === 'airport' && !$this->from_airport && !$this->to_airport) {
                $validator->errors()->add('from_airport', 'Either from_airport or to_airport must be true for airport trips.');
            }
        });
    }
}
