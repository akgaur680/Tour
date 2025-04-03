@extends('layouts.emailTemplate')

@section('email-content')

<div class="container">
    <h2>Booking Confirmation</h2>
    <p>Hi {{ $orderDetails->user['name'] }},</p>
    <p><strong>{{ $emailTitle }}</strong> is confirmed!</p>
    <p>You will receive your driver details within 45 minutes of your pickup time. We seek your cooperation to avoid enquiring about the driver details before the specified time. With SardarJi Cabs, Garage to Garage charging which is a norm for Car Rental companies is a thing of the past with SardarJi Cabs. For your trip, you will be charged ONLY for the distance and time taken to travel from your Pickup location back to the same Pickup location. Kindly check the attachment for the complete billing details.</p>

    <p>Below is a summary of your booking:</p>

    <div class="details">
        <p><strong>Pickup Time:</strong>{{ date('h:i', strtotime($orderDetails->pickup_time)) }} {{ date('A', strtotime($orderDetails->pickup_time)) }}
        </p>
        <p><strong>Pickup Location:</strong> {{ $orderDetails->trip_type == 'airport' && $orderDetails->from_airport ? $orderDetails->airport['name'] : $orderDetails->pickup_location }}</p>
        <p><strong>Trip Details:</strong>
            @if ($orderDetails->trip_type == 'airport')
            Airport Trip
            @elseif ($orderDetails->trip_type == 'round-trip')
            Round Trip
            @elseif ($orderDetails->trip_type == 'local')
            Local Trip ({{ $orderDetails->total_hours }} hrs / {{ $orderDetails->total_hours * 10 }} km)
            @else
            One Way Trip
            @endif
        </p>
        <p><strong>Car Type:</strong> {{ $orderDetails->car['car_type'] }} , {{ $orderDetails->car['car_model'] }}</p>
        <p><strong>Phone No:</strong> {{ str_repeat('*', strlen($orderDetails->user['mobile_no']) - 4) . substr($orderDetails->user['mobile_no'], -4) }}
        </p>
    </div>

    <p>We are proud of our promise of complete transparency in our service offerings. Please note the important T&C of your trip:</p>

    @if ($orderDetails->is_chauffeur_needed || $orderDetails->is_new_car_promised || $orderDetails->is_cab_luggage_needed || $orderDetails->is_diesel_car_needed)
    <h3>Special Services:</h3>
    <ul>
        @if ($orderDetails->is_chauffeur_needed && !empty($orderDetails->preffered_chauffeur_language))
        <li>Chauffeurs who know your language: <strong>{{ $orderDetails->preffered_chauffeur_language }}</strong></li>
        @endif
        @if ($orderDetails->is_new_car_promised)
        <li>New Car Promise - Model that is <strong>2022 or newer</strong></li>
        @endif
        @if ($orderDetails->is_cab_luggage_needed)
        <li>Cab with <strong>Luggage Carrier</strong></li>
        @endif
        @if ($orderDetails->is_diesel_car_needed && isset($orderDetails->diesel_car_price))
        <li><strong>Diesel Car For</strong> ₹{{ number_format($orderDetails->diesel_car_price, 2) }} / km</li>
        @endif
    </ul>
    @endif

    <h3>Important Terms & Conditions:</h3>
    @php
    $tripType = $orderDetails->trip_type['slug'] ?? 'default';
    $carPricePerKm = $orderDetails->car['price_per_km'] ?? 0;
    $distance = $orderDetails->distance ?? 0;
    $carPricePerHour = $orderDetails->car_price_per_hour ?? null;

    function getTripInclusions($tripType, $carPricePerKm, $distance): array {
    return match ($tripType) {
    'one-way' => ['Fuel Charges', 'Driver Allowance', 'Toll / State Tax (₹680 - ₹810)', 'GST 5%'],
    'local' => ['Fuel Charges', 'Driver Allowance', 'GST 5%'],
    'airport' => ['Fuel Charges', 'Driver Allowance', 'Night Allowance', 'Airport Parking', 'Toll / State Tax (₹680 - ₹810)', 'GST 5%'],
    default => ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Fuel Charges', 'Driver Allowance', 'GST 5%']
    };
    }

    function getTripExclusions($tripType, $carPricePerKm, $distance, $carPricePerHour = null): array {
    return match ($tripType) {
    'one-way' => ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Multiple pickups/drops', 'Airport Entry/Parking'],
    'local' => [
    "Pay ₹{$carPricePerKm}/km after {$distance} Km",
    "Pay ₹{$carPricePerHour}/hour after " . ceil($distance / 10) . " Hours",
    'Toll / State Tax (₹680 - ₹810)',
    'Night Allowance',
    'Parking'
    ],
    'airport' => ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Airport Entry/ Parking', 'Multiple Pickups'],
    default => ['Toll / State Tax (₹680 - ₹810)', 'Night Allowance', 'Parking'],
    };
    }

    // Now call the functions
    $inclusions = getTripInclusions($tripType, $carPricePerKm, $distance);
    $exclusions = getTripExclusions($tripType, $carPricePerKm, $distance, $carPricePerHour);
    @endphp

    <ul>
        @if($tripType == 'local')
        <li>Your Trip has a KM limit as well as an Hours limit. If your usage exceeds these limits, you will be charged for the excess KM and/or hours used.</li>
        <li>The KM and Hour(s) usage will be calculated based on the distance from your pick-up point and back to the pick-up point.</li>
        <li>Charges apply for toll fees, parking, state taxes, etc.</li>
        <li>Night driving allowance (09:45 PM - 06:00 AM) applies.</li>
        <li>The Airport entry charge, if applicable, is not included in the fare and will be charged extra.</li>
        @elseif($tripType == 'one-way')
        <li>One-way fare includes fuel, driver, and toll/state tax.</li>
        <li>Excess distance beyond {{ $distance }} KM will be charged at ₹{{ $carPricePerKm }}/km.</li>
        <li>Multiple pickups and drops are not allowed.</li>
        <li>Airport parking/entry fees are not included.</li>
        @elseif($tripType == 'airport')
        <li>Fare includes fuel, driver, airport parking, and night allowance.</li>
        <li>Excess distance beyond {{ $distance }} KM will be charged at ₹{{ $carPricePerKm }}/km.</li>
        <li>Multiple pickups/drops are not allowed.</li>
        @else
        <li>Trip includes driver and fuel charges.</li>
        <li>Additional charges apply for tolls, night allowance, and parking.</li>
        <li>Excess KM beyond {{ $distance }} KM will be charged at ₹{{ $carPricePerKm }}/km.</li>
        @endif
        <li>
            We have received your special services and 5% GST will be charged on each request. In case we are unable to fulfill one or more attributes, the charges for such request/s will be 0 (Zero).
        </li>
    </ul>

    <p>We request you to go through the detailed list of terms applicable for your trip to ensure a smooth experience.</p>

    <p class="footer">For any concerns, call our 24x7 helpline at <strong>9045450000</strong> or email <strong>orders@saradrJi.com</strong>.</p>
    <p>Thank You,<br><strong>Team SararJi</strong></p>
</div>

@endsection