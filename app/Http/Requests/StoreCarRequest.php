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
            'technical_condition_id' => 'required|integer|exists:technical_conditions,id',
            'manufacturer_id' => 'required|integer|exists:manufacturers,id',
            'transmission_id' => 'required|integer|exists:transmissions,id',
            'car_model_id' => 'required|integer|exists:car_models,id',
            'body_type_id' => 'required|integer|exists:body_types,id',
            'ext_color_id' => 'required|integer|exists:colors,id',
            'int_color_id' => 'required|integer|exists:colors,id',
            'drive_id' => 'required|integer|exists:drives,id',
            'trim_id' => 'required|integer|exists:trims,id',
            'fuel_id' => 'required|integer|exists:fuels,id',
            'door_id' => 'required|integer|exists:doors,id',
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
