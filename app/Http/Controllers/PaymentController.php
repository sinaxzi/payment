<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Category;
use App\Models\Employee;
use App\Events\ChangePaymentStatus;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::paginate(10);
        return view('home.index',['payments' => $payments]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('payments.create',['categories' =>$categories]);
    }

    public function store(StorePaymentRequest $storePaymentRequest)
    {
        $fields = $storePaymentRequest->validated();
        
        if(request('attachment')){
            $fields['attachment'] = Storage::putFile('attachments', $storePaymentRequest->file('attachment'));
        }

        Payment::create([
            'category_id' =>  (int) $fields['category'],
            'employee_id' => Employee::firstWhere(['national_code' => $fields['national_code']])->id,
            'price' => $fields['price'],
            'shaba' => $fields['shaba'],
            'status' => Payment::STATUS_WAIT_FOR_APPROVE,
            'description' => $fields['description'],
            'attachment' => !empty($fields['attachment']) ? $fields['attachment'] : null
        ]);

        Session::flash('payment-created-message','Payment was created');

        return redirect()->route('payment.create');
    }

    public function accept(Payment $payment){
        if($payment->accept()){
            //send email:
            // event(new ChangePaymentStatus($payment->employee,$payment,'accepted'));
            Session::flash('payment-accepted-message','Payment accepted and added to queue');
        }else{
            Session::flash('payment-forbidden-message','You Can not change status of payment');
        }

        return redirect()->route('home');
    }

    public function reject(Payment $payment){
        if($payment->reject()){
            //send email:
            // event(new ChangePaymentStatus($payment->employee,$payment,'rejected'));
            Session::flash('payment-rejected-message','Payment rejected');
        }else{
            Session::flash('payment-forbidden-message','You Can not change status of payment');
        }

        return redirect()->route('home');
    }

    public function pay(Payment $payment){
        if($payment->status == Payment::STATUS_ACCEPTED_AND_WAIT_FOR_PAYMENT){
            if($payment->pay()){
                //send email:
                // event(new ChangePaymentStatus($payment->employee,$payment,'paid'));
                Session::flash('payment-success-message','Payment paid');
            }else{
                //send email:
                // event(new ChangePaymentStatus($payment->employee,$payment,'failed'));
                Session::flash('payment-fail-message','Payment failed');
            }
        }else{
            Session::flash('payment-forbidden-message','You Can not change status of payment');
        }
        
        return redirect()->route('home');
    }

    public function download(Payment $payment){
        return Storage::download($payment->attachment);
    }
}
