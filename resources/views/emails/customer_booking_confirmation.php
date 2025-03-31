<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007BFF;
        }
        .details {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Booking Confirmation</h2>
        <p>Hi {{ $orderDetails->user->name }},</p>
        <p>{{ $emailTitle }}</p>

        <p>Your <strong>{{ $orderDetails->trip_type->name == 'Local' ? 'Local ' . $orderDetails->total_hours . ' hrs/' . ($orderDetails->total_hours * 10) . ' km' : $orderDetails->trip_type->name }}</strong> booking <strong>ID {{ $orderDetails->booking_token }}</strong> on <strong>{{ $orderDetails->pickup_date }}</strong> from:</p>
        <p><strong>{{ $orderDetails->from_address_city->name }}</strong> is confirmed!</p>
        <p>You will receive your driver details within 45 minutes of your pickup time.</p>

        <div class="details">
            <p><strong>Pickup Time:</strong> 7:00 AM</p>
            <p><strong>Pickup Location:</strong> {{ $orderDetails->from_address_city->name }}</p>
            <p><strong>Trip Details:</strong> Local (8hr/80 km)</p>
            <p><strong>Car Type:</strong> Toyota Etios or equivalent</p>
            <p><strong>Phone No:</strong> ********8230</p>
        </div>

        <h3>Special Services:</h3>
        <ul>
            <li>Chauffeurs who know your language: <strong>English</strong></li>
            <li>New Car Promise - Model that is <strong>2022 or newer</strong></li>
            <li>Cab with <strong>Luggage Carrier</strong></li>
        </ul>

        <h3>Important Terms & Conditions:</h3>
        <ul>
            <li>Your trip has a KM and Hour limit. Excess usage will be charged.</li>
            <li>Charges apply for toll fees, parking, state taxes, etc.</li>
            <li>Night driving allowance (09:45 PM - 06:00 AM) applies.</li>
            <li>Airport entry charge is not included.</li>
        </ul>

        <p class="footer">For any concerns, call our 24x7 helpline at <strong>9045450000</strong> or email <strong>orders@savaari.com</strong>.</p>
        <p>Thank You,<br><strong>Team Savaari</strong></p>
    </div>
</body>
</html>
