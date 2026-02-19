<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3', 
            'from_city' => 'required|string|min:3', 
            'from_country' => 'required|string|min:3',
            'to_city' => 'required|string|min:3', 
            'to_country' => 'required|string|min:3', 
            'price' => 'required|integer|gt:0',
            'status' => 'required|in:in_progress,unassigned,problem,completed', 
            'details' => 'required|string',
            'user_id' => 'required|integer|exists:users,user_id'
        ];
    }
}