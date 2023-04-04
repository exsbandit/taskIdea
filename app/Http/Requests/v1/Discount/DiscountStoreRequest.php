<?php

namespace App\Http\Requests\v1\Discount;

use Illuminate\Foundation\Http\FormRequest;

class DiscountStoreRequest extends FormRequest
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
            'type' => ['array', 'required'],
            'type.*' => ['string', 'required'],
            'selection' => ['array', 'sometimes'],
            'selection.*' => ['integer', 'required'],
            'desc' => ['string', 'required'],
            'unit' => ['string', 'required'],
            'rule' => ['string', 'required'], // equal or greater
            'control' => ['sometimes'],
            'input' => ['string', 'required', 'max:50'],
        ];
    }
}
