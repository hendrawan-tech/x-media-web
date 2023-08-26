<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'external_id' => ['required', 'max:255', 'string'],
            'invoice_url' => ['required', 'max:255', 'string'],
            'price' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
