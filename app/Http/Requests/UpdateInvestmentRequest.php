<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvestmentRequest extends FormRequest
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
            'status' => 'required|in:pending,under_process,approved,rejected,cancelled',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:500',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'investor_id.required' => 'يجب اختيار المستثمر',
            'status.required' => 'يجب اختيار الحالة',
            'status.in' => 'حالة غير صحيحة',
            'amount.required' => 'يجب إدخال المبلغ',
            'rejection_reason.required_if' => 'يجب إدخال سبب الرفض',
        ];
    }
}