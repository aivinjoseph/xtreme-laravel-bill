<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceApplicationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'sin' => 'nullable|string',
            'dob' => 'required|date',
            'marital_status' => 'required|string',
            'license_number' => 'required|string',
            'license_expiry' => 'required|date',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
            'residence_type' => 'required|string',
            'rent_mortgage_amount' => 'required|integer',
            'employer' => 'required|string',
            'employer_phone' => 'required|string',
            'job_title' => 'required|string',
            'job_length' => 'required|string',
            'income_amount' => 'required|string',
            'income_frequency' => 'required|string',
            'employer_address' => 'required|string',
            'co_applicant' => 'nullable', // Assuming co_applicant is an array in JSON format
            'trade_in' => 'nullable',
        ];
    }
}
