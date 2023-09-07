<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Illuminate\Console\Command;

class Pay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Doing payments that are waiting to pay';

    public function handle()
    {
        $payments = Payment::where(['status' => Payment::STATUS_ACCEPTED_AND_WAIT_FOR_PAYMENT])->get();

        foreach($payments as $payment){
            if($payment->pay()){
                //send email:
                // event(new ChangePaymentStatus($payment->employee,$payment,'paid'));
            }
        }
    }
}
