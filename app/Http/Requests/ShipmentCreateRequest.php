<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentCreateRequest extends FormRequest
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
            'title' => 'required|string|min:3', 
            'from_city' => 'required|string|min:3', 
            'from_country' => 'required|string|min:3',
            'to_city' => 'required|string|min:3', 
            'to_country' => 'required|string|min:3', 
            'price' => 'required|integer|gt:0',
            'status' => 'required|string', 
            'details' => 'required|string',
        ];
    }
}
