<?php

namespace App\Http\Resources\v1\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderWithProductResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customerId' => $this->customerId,
            'items' => OrderProductResource::collection($this->products),
            'total' => $this->total
        ];
    }
}
