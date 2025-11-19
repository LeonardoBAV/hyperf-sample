<?php

namespace App\Resource;

use Hyperf\Resource\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return ['data' => $this->collection->map(function ($item) {
            return (new ProductResource($item))->toArray();
        })];
    }
}
