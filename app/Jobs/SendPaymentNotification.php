<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendPaymentNotification implements ShouldQueue
{
    use Queueable;

    public $imageUrl;
    /**
     * Create a new job instance.
     */
    public function __construct($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
