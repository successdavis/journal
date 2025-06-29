<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'user_id' => ['required', 'exists:users,id'],
//            'publication_id' => ['nullable', 'exists:publications,id'],
//            'amount' => ['required', 'numeric', 'min:0'],
//            'currency' => ['required', 'string', 'size:3'],
//            'payment_method' => ['nullable', 'string', 'max:50'],
//            'reference' => ['required', 'string', 'unique:payments,reference'],
//            'receipt_no' => ['required', 'string', 'unique:payments,receipt_no'],
//            'status' => ['required', 'in:pending,successful,failed'],
//            'paid_at' => ['nullable', 'date'],
//            'metadata' => ['nullable', 'array'], // if you cast it to array in model
        ];

    }
}
