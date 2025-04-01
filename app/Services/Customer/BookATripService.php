<?php

namespace App\Services\Customer;

use App\Jobs\sendBookingNotificationsViaEmail;
use App\Jobs\sendBookingNotificationsViaWhatsapp;
use App\Models\Airport;
use App\Models\FixedTourPrices;
use App\Models\Order;
use App\Models\TripType;
use App\Services\CoreService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookATripService extends CoreService
{
    public function bookATrip($request)
    {
        return match ($request->trip_type) {
            'one-way' => $this->bookOneWayTrip($request),
            'local' => $this->bookLocalTrip($request),
            'round-trip' => $this->bookRoundTrip($request),
            'airport' => $this->bookAirportTrip($request),
        };
    }

    private function bookOneWayTrip($request)
    {
        return $this->createOrder($request , [
            'to_address_city_id' => $this->extractLocationDetails($request->to_address)['city_id'],
            'to_address_state_id' => $this->extractLocationDetails($request->to_address)['state_id'],
        ]);
    }

    private function bookLocalTrip($request)
    {
        return $this->createOrder($request, ['total_hours' => $request->total_hours]);
    }

    private function bookRoundTrip($request)
    {
        return $this->createOrder($request, ['return_date' => $request->return_date]);
    }

    private function bookAirportTrip($request)
    {
        $airportName = strtok($request->airport_location, ',');

        $checkFixedPrice = FixedTourPrices::where([
            ['trip_type_id', TripType::where('slug', $request->trip_type)->value('id')],
            ['airport_id', Airport::where('name', $airportName)->value('id')],
            ['car_id', $request->car_id]
        ])->exists();

        if (!$checkFixedPrice) {
            return $this->jsonResponse(false, 'No Booking Available for this route.');
        }

        $airportId = Airport::where('name', $airportName)->value('id');

        $additionalData = ['airport_id' => $airportId];
        if ($request->to_airport) {
            return $this->createOrder($request, $additionalData);
        }

        return $this->createOrder($request, array_merge($additionalData, [
            'to_address_city_id' => $this->extractLocationDetails($request->to_address)['city_id'],
            'to_address_state_id' => $this->extractLocationDetails($request->to_address)['state_id'],
        ]));
    }

    private function createOrder($request, array $additionalData = [])
    {
        try {
            $from = $this->extractLocationDetails($request->from_address);
            $to = $this->extractLocationDetails($request->to_address);
            $tripTypeId = TripType::where('slug', $request->trip_type)->value('id');

            DB::beginTransaction();

            $orderData = array_merge([
                'booking_token' => 'S' . date('md') . '-' . rand(1000000, 9999999),
                'from_address_city_id' => $from['city_id'],
                'from_address_state_id' => $from['state_id'],
                'trip_type_id' => $tripTypeId,
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'user_id' => $request->user()->id,
                'driver_id' => $request->driver_id,
                'pickup_location' => $request->pickup_location ?? null,
                'drop_location' => $request->drop_location ?? null,
                'car_id' => $request->car_id,
                'is_chauffeur_needed' => $request->is_chauffeur_needed,
                'chauffeur_price' => $request->chauffeur_price,
                'preffered_chauffeur_language' => $request->preffered_chauffeur_language,
                'is_new_car_promised' => $request->is_new_car_promised,
                'new_car_price' => $request->new_car_price,
                'is_cab_luggage_needed' => $request->is_cab_luggage_needed,
                'cab_luggage_price' => $request->cab_luggage_price,
                'is_diesel_car_needed' => $request->is_diesel_car_needed,
                'diesel_car_price' => $request->diesel_car_price,
                'received_amount' => $this->checkReceivedAmount($request->payment_type, $request->total_amount),
                'original_amount' => $request->total_amount,
                'total_distance' => (int) $request->total_distance,
                'payment_status' => 'pending',
                'booking_status' => 'upcoming',
            ], $additionalData);

            $bookOrder = Order::create($orderData);

            DB::commit();

            if ($bookOrder) {
                $orderDetails =  Order::with([
                    'tripType',
                    'car',
                    'user',
                    'fromAddressCity',
                    'fromAddressState',
                    'toAddressCity',
                    'toAddressState',
                    'airport'
                ])->find($bookOrder->id)->toArray();

                sendBookingNotificationsViaEmail::dispatch($orderDetails);
                // sendBookingNotificationsViaWhatsapp::dispatch($bookOrder);

                $orderDetails['qrCode'] = url('storage/qrCode/' . 'UpiQrCode.png');
                return $this->jsonResponse(true, ucfirst(str_replace('-', ' ', $request->trip_type)) . ' Trip booked successfully.', $orderDetails);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking failed: ' . $e->getMessage(), ['request' => $request->all()]);
            return $this->jsonResponse(false, 'Something went wrong', $e->getMessage());
        }
    }

    private function checkReceivedAmount($paymentType, $totalAmount)
    {
        return match ($paymentType) {
            'Half Payment' => $totalAmount / 2,
            'Partial Payment' => $totalAmount / 4,
            'Full Payment' => $totalAmount,
            'Pay on Delivery' => 0,
            default => 0,
        };
    }
}
