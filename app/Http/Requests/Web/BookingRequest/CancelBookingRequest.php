<?php

namespace App\Http\Requests\Web\BookingRequest;

use App\Http\Requests\BaseRequest;

class CancelBookingRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booking_status' => ['required','string', 'max:2048'],
        ];
    }
}
