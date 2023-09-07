<?php

namespace App\Http\Requests;

use App\Rules\ShabaCheck;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => 'required|exists:App\Models\Category,id',
            'national_code' => 'required|string|numeric|digits:10|exists:App\Models\Employee,national_code',
            'price' => 'required|integer',
            'shaba' => ['required','string','numeric','digits:24', new ShabaCheck],
            'description' => 'nullable|string',
            'attachment' => 'nullable|file'
        ];
    }
}
