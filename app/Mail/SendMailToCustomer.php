<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class SendMailToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $orderDetails;
    public $emailTitle;
    public $emailSubject;

    /**
     * Create a new message instance.
     */
    public function __construct($orderDetails)
    {

        $this->orderDetails = $orderDetails;
        $this->emailSubject = $this->generateTripSubject($this->orderDetails);
        $this->emailTitle = $this->generateTripTitle($this->orderDetails);

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚖' .$this->emailSubject .'🚖', 
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customer_booking_confirmation',
            with: [
                'orderDetails' => $this->orderDetails,
                'emailTitle' => $this->emailTitle,
            ]
        );
    }

    /**
     * Generate Trip Title and Subject for the Email.
     */
    private function generateTripTitle($orderDetails)
    {
        return match ($orderDetails->trip_type['slug']) {
            'one-way' => "Your confirmed One Way booking from {$orderDetails->pickup_location} to {$orderDetails->drop_location} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            'local' => "Your confirmed Local ({$orderDetails->total_hours} hrs/" . ($orderDetails->total_hours * 10) . " km) booking in {$orderDetails->pickup_location} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            'round-trip' => "Your confirmed Round booking from {$orderDetails->pickup_location} - {$orderDetails->drop_location} - {$orderDetails->pickup_location} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            'airport' => $orderDetails->to_airport 
                ? "Your confirmed Airport booking from {$orderDetails->pickup_location} - {$orderDetails->airport['name']} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})"
                : "Your confirmed Airport booking from {$orderDetails->airport['name']} - {$orderDetails->drop_location} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            default => "Your confirmed booking (ID: {$orderDetails->booking_token})"
        };
    }



    private function generateTripSubject($orderDetails)
    {
        return match ($orderDetails->trip_type['slug']) {
            'one-way' => "Your confirmed One Way booking from {$orderDetails->from_address_city['name']} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            'local' => "Your confirmed Local ({$orderDetails->total_hours} hrs/" . ($orderDetails->total_hours * 10) . " km) booking in {$orderDetails->from_address_city['name']} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            'round-trip' => "Your confirmed Round booking from {$orderDetails->from_address_city['name']} - {$orderDetails->to_address_city['name']} - {$orderDetails->from_address_city['name']} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            'airport' => $orderDetails->to_airport 
                ? "Your confirmed Airport booking from {$orderDetails->from_address_city['name']} - {$orderDetails->airport['name']} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})"
                : "Your confirmed Airport booking from {$orderDetails->airport['name']} - {$orderDetails->from_address_city['name']} on {$orderDetails->pickup_date} (ID: {$orderDetails->booking_token})",
            default => "Your confirmed booking (ID: {$orderDetails->booking_token})"
        };
    }
}
