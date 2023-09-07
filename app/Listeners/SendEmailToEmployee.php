<?php

namespace App\Listeners;

use App\Events\ChangePaymentStatus;
use App\Mail\PaymentEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToEmployee
{
    
    public function __construct()
    {
        //
    }

    public function handle(ChangePaymentStatus $event): void
    {
        Mail::send(new PaymentEmail($event->employee, $event->payment, $event->status));
    }
}
