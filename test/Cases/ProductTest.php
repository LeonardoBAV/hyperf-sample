<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace HyperfTest\Cases;

use Hyperf\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ProductTest extends TestCase
{
    public function testProductList()
    {
        $response = $this->get('/products');
        $response->assertOk();
    }

    public function testProductCreate()
    {
        $response = $this->post('/products', ['name' => 'Test Product', 'price' => 100]);
        $response->assertCreated();
    }

    public function testProductUpdate()
    {
        $response = $this->put('/products/2', ['name' => 'Test Product', 'price' => 100]);
        $response->assertOk();
    }

    public function testProductDelete()
    {
        $response = $this->post('/products', ['id' => 1, 'name' => 'Test Product', 'price' => 100]);
        $data = json_decode($response->getBody()->getContents(), true);
        $id = $data['data']['id'];

        $response = $this->delete('/products/' . $id);
        $response->assertNoContent();
    }
}
