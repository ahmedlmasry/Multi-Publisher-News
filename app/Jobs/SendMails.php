<?php

namespace App\Jobs;

use App\Mail\Frontend\NewSubscriberMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMails implements ShouldQueue
{
    use Queueable;
    public $email;
    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new NewSubscriberMail());
    }
}
