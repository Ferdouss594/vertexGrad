<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvestmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'investor_id' => 'required|exists:investors,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'investor_id.required' => 'يجب اختيار المستثمر',
            'investor_id.exists' => 'المستثمر غير موجود',
            'amount.required' => 'يجب إدخال المبلغ',
            'amount.numeric' => 'المبلغ يجب أن يكون رقماً',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
        ];
    }
}