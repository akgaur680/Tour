<?php

namespace App\Jobs;

use App\Mail\SendMailToCustomer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class sendBookingNotificationsViaWhatsapp implements ShouldQueue
{
    use Queueable;

    public $order;
    /**
     * Create a new job instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    }
}
