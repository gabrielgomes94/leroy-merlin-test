<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAllProducts()
    {
        factory(Product::class)->create([
            'lm' => '123456',
            'name' => 'First Product'
        ]);

        factory(Product::class)->create([
            'lm' => '234567',
            'name' => 'Second Product'
        ]);

        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $response = $this->json('GET', '/api/products', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'lm', 'name', 'free_shipping', 'description', 'price', 'category', 'created_at', 'updated_at'],
            ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
