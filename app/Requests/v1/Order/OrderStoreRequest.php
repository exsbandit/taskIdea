<?php

namespace App\Http\Requests\v1\Order;

use App\Rules\v1\ProductStockRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customerId' => ['integer', 'required', 'exists:customers,id'],
            'products' => ['array', 'required'],
            'products.*.id' => ['integer', 'required', 'exists:products,id'],
            'products.*.quantity' => ['integer', 'required', 'min:1', new ProductStockRule($this->products)],
        ];
    }
}
