<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class ShowOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "order" => 'required|string|exists:'.Order::class.',id',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge(['order' => $this->route('order')]);
    }
}
