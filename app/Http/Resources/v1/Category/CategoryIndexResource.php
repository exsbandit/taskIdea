<?php

namespace App\Http\Resources\v1\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'name' => $this->name,
          'tarih' => $this->created_at
        ];

        //return parent::toArray($request);
    }
}
