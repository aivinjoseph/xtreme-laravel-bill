<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'technical_condition' => 'required|string',
            'make' => 'required|string',
            'transmission' => 'required|string|min:1',
            'model' => 'required|string|min:1',
            'body_type' => 'required|string|min:1',
            'ext_color' => 'required|string|min:1',
            'int_color' => 'required|string|min:1',
            'drive' => 'required|string|min:1',
            'trim' => 'required|string|min:1',
            'fuel' => 'required|string|min:1',
            'door' => 'required|string|min:1',
            'name' => 'required|string|max:255',
            'availability' => 'required|string',
            'description' => 'required|string',
            'mileage' => 'required|integer',
            'features' => 'required|array',
            'price' => 'required|integer',
            'seats' => 'required|integer',
            'engine' => 'required|string',
            'year' => 'required|integer',
        ];
    }
}
