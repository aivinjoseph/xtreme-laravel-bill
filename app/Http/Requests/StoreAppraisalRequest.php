<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppraisalRequest extends FormRequest
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
            'first_name' => ['required', 'min:2', 'max:100'],
            'last_name' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'make' => ['required'],
            'model' => ['required'],
            'trim' => ['required'],
            'engine' => ['required'],
            'transmission' => ['required'],
            'year' =>  'required|integer|min:1970|max:' . (date('Y') + 1),
            'mileage' => ['required'],
            'description' => ['required', 'max:2000'],
        ];
    }
}
