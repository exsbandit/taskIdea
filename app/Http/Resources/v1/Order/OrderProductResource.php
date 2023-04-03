<?php

namespace App\Http\Resources\v1\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'productId' => $this->productId,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unitPrice,
            'total' => $this->total
        ];
    }
}
