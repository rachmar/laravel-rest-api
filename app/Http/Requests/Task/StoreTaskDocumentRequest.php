<?php

namespace App\Http\Requests\Task;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskDocumentRequest extends FormRequest
{   
    public $allowedMimeTypes = [
        'image/svg',
        'image/png',
        'image/jpeg',
        'video/mp4',
        'application/csv',
        'text/plain',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {   
        return [
            'documents.*' => [
                'required',
                'file',
                'mimetypes:' . implode(',', $this->allowedMimeTypes),
            ]
        ];
        
    }
}
