<?php

namespace App\Http\Resources\v1\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderWithDiscountResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'orderId' => $this->id,
            'discounts' => OrderDiscountResource::collection($this->discounts),
            "totalDiscount" => $this->discounts->sum('discountAmount'),
            "discountedTotal" => $this->discounts->last()->subtotal,
        ];
    }
}
