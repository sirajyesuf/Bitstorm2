<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [

            "id" =>  $this->id,
            "name" => $this->title,
            "thumbnail_image" =>  $this->image,
            "base_price" => $this->price,
            'is_featured' => $this->is_featured,
            'category_id' => $this->category_id,
            "rating" => 0,
            "sales" =>  5,
            // "links": {
            //     "details": "http://127.0.0.1:8000/api/v2/products/18"
            // }
        ];
    }
}
