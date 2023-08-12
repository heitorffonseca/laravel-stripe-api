<?php

namespace Tests\Feature;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_list(): void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_new_product()
    {
        $factory = new ProductFactory();

        $response = $this->post('/api/products', $factory->raw());

        $response->assertStatus(201);
    }
}
