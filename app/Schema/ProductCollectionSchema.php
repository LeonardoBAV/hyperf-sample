<?php

declare(strict_types=1);

namespace App\Schema;

use Hyperf\Swagger\Annotation as SA;

#[SA\Schema(
    schema: 'ProductCollection',
    properties: [
        new SA\Property(
            property: 'data',
            description: 'List of products',
            type: 'array',
            items: new SA\Items(ref: '#/components/schemas/Product')
        ),
    ]
)]
class ProductCollectionSchema
{
}

