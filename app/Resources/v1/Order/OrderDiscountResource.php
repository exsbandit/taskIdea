<?php

namespace App\Http\Resources\v1\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDiscountResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'discountReason' => $this->discountReason,
            'discountAmount' => $this->discountAmount,
            'subtotal' => $this->subtotal
        ];
    }
}
