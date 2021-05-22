<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return [
//            'title' => $this->title,
//            'description' => $this->description,
//            'sale_price' => $this->sale_price,
//            'rental_price' => $this->rental_price,
//            'slug' => $this->slug
//        ];
        return $this->resource->toArray();
    }
}
