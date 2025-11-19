<?php

declare(strict_types=1);

namespace App\Schema;

use Hyperf\Swagger\Annotation as SA;

#[SA\Schema(
    schema: 'ProductRequest',
    required: ['name', 'price'],
    properties: [
        new SA\Property(property: 'name', description: 'Product name', type: 'string', example: 'New Product'),
        new SA\Property(property: 'price', description: 'Product price', type: 'string', example: '49.99'),
    ]
)]
class ProductRequestSchema
{
}

