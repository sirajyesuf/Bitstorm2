<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CategoryResource;

class CategoryCollection extends ResourceCollection
{
  

    public $collects = CategoryResource::class;
    
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
