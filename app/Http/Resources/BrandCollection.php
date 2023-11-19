<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BrandResource;

class BrandCollection extends ResourceCollection
{
    
    public $collects = BrandResource::class;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
