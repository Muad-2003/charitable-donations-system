<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullName' => 'required|max:255',
            'surname' => 'required|max:255',
            'ssn' => 'required|digits:12|unique:beneficiaries',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required',
            'address' => 'required',
            'phone_number' => 'required|digits:10',
            'notes' => 'nullable',
            'personal_photo' => 'nullable|image|mimes:png,jpg|max:2048',
            'bank_statement_photo' => 'nullable|image|mimes:png,jpg|max:2048',
        ];
    }
}
