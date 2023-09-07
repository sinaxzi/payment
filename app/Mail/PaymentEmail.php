<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $payment;
    public $status;
    public function __construct($employee,$payment,$status)
    {
        $this->employee = $employee;
        $this->payment = $payment;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('payment' . $this->status)
            ->from('admin@example.com')
            ->to($this->employee->email)
            ->view('mail.payment', ['employee' => $this->employee,'payment' => $this->payment,'status' => $this->status]);
    }
}
