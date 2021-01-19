<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testCanCreateProduct()
    {
        $product = ['name' => "Success", 'description' => "Test Desc", 'price' => 100, 'image' => null];
        $data = ['product' => $product, 'categories' => null];

        $response = $this->json('POST', '/api/addProduct', $data);

        $response->assertStatus(201);
    }
}
