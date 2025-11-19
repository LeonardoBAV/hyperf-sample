<?php

declare(strict_types=1);

namespace App\Schema;

use Hyperf\Swagger\Annotation as SA;

#[SA\Schema(
    schema: 'Product',
    properties: [
        new SA\Property(property: 'id', description: 'Product ID', type: 'integer', example: 1),
        new SA\Property(property: 'name', description: 'Product name', type: 'string', example: 'Sample Product'),
        new SA\Property(property: 'price', description: 'Product price', type: 'string', example: '99.99'),
    ]
)]
class ProductSchema
{
}

