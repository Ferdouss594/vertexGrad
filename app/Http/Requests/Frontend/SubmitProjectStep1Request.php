<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SubmitProjectStep1Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_title'   => 'required|string|max:100',
            'abstract'        => 'required|string|max:1000',
            'discipline'      => 'required|string|max:50',

            'project_photos'   => 'nullable|array',
            'project_photos.*' => 'image|max:5120',

            'project_video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/ogg|max:51200',
        ];
    }
}