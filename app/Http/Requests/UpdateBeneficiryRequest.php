<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBeneficiryRequest extends FormRequest
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
            'fullName' => 'required|string|max:255',
            'surname' => 'required|string|max:255',        
            'ssn' => 'required|digits:12|unique:beneficiaries,ssn,' . $this->beneficiary->id,
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|digits:10',
            'notes' => 'nullable|string',
            'personal_photo' => 'nullable|image|mimes:jpg,png|max:2048',
            'bank_statement_photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ];
    }
}
