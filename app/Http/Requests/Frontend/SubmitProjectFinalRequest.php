<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SubmitProjectFinalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Final submit doesn’t need inputs from the request usually
        // because you use session data. Keep it strict and empty.
        return [];
    }
}