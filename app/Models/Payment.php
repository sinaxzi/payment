<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'employee_id',
        'price',
        'description',
        'status',
        'shaba',
        'attachment'
    ];

    const STATUS_WAIT_FOR_APPROVE = 0;
    const STATUS_ACCEPTED_AND_WAIT_FOR_PAYMENT = 1;
    const STATUS_REJECTED = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_FAIL = 4;


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function payment_logs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function statusName($status){
        return  match ($status) {
            0 => 'WAIT FOR APPROVE',
            1 => 'ACCEPTED AND WAIT FOR PAYMENT',
            2 => 'REJECTED',
            3 => 'SUCCESS',
            4 => 'UNSUCCESS',
        };
    }
    public function accept(){
        if($this->status == self::STATUS_WAIT_FOR_APPROVE){
            $this->status = self::STATUS_ACCEPTED_AND_WAIT_FOR_PAYMENT;
            if($this->save()){
                PaymentLog::create([
                    'payment_id' => $this->id,
                    'status' => 'accepted',
                    'message' => 'payment accepted'
                ]);
                return true;
            }
        }

        return false; 
    }
    public function reject(){
        if($this->status == self::STATUS_WAIT_FOR_APPROVE){
            $this->status = self::STATUS_REJECTED;
            if($this->save()){
                PaymentLog::create([
                    'payment_id' => $this->id,
                    'status' => 'rejected',
                    'message' => 'payment rejected'
                ]);
                return true;
            }
        }

        return false; 
    }

    public function pay(){
        $bank = Bank::firstWhere(['pattern' => substr($this->shaba,0,2)]);
        $employee = Employee::firstWhere(['national_code' => $this->employee->national_code]);
        if(empty($bank)){
            PaymentLog::create([
                'payment_id' => $this->id,
                'status' => 'failed',
                'message' => 'shaba is invalid'
            ]);
            $this->status = self::STATUS_FAIL;
            $this->save();
            return false;
            
        }elseif(empty($employee)){
            PaymentLog::create([
                'payment_id' => $this->id,
                'status' => 'failed',
                'message' => 'employee not found with this national code'
            ]);

            $this->status = self::STATUS_FAIL;
            $this->save();
            return false;
        }

        ////bank api
        // $response = Http::post('http://'.$bank->name.'api.com/payment', [
        //     'shaba' => $this->shaba,
        //     'price' => $this->price,
        //     'token' => '123456'
        // ]);

        // if($response->failed()){
        //     PaymentLog::create([
        //         'payment_id' => $this->id,
        //         'status' => 'failed',
        //         'message' => $response->message()
        //     ]);

        //     $this->status = self::STATUS_FAIL;
        //     $this->save();
        //     return false;
        // }

        PaymentLog::create([
            'payment_id' => $this->id,
            'status' => 'success',
            'message' => 'payment done successfully'
        ]);
        
        $this->status = self::STATUS_SUCCESS;
        $this->save();
        return true;
    }
}
