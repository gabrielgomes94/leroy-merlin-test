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

    public function testsShowProductCorrectly()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $product = factory(Product::class)->create([
            'lm' => '123456',
            'name' => 'First Product'
        ]);

        $this->json('GET', '/api/products/' . $product->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => $product->id,
                'lm' => '123456',
                'name' => 'First Product'
            ]);
    }

    public function testsProductsAreUpdatedCorrectly()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $product = factory(Product::class)->create([
            'lm' => '123456',
            'name' => 'First Product'
        ]);

        $payload = [
            'name' => 'Updated product',
        ];

        $response = $this->json('PUT', '/api/products/' . $product->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => $product->id,
                'name' => 'Updated product'
            ]);
    }

    public function testsProductsAreDeletedCorrectly()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $product = factory(Product::class)->create([
            'lm' => '123456',
            'name' => 'First Product'
        ]);

        $this->json('DELETE', '/api/products/' . $product->id, [], $headers)
            ->assertStatus(204);
    }

    public function testsProductsAreNotFound()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $product = factory(Product::class)->create([
            'lm' => '123456',
            'name' => 'First Product'
        ]);

        $this->json('GET', '/api/products/' . ($product->id + 1), [], $headers)
            ->assertStatus(404);
    }

    public function testProductsWithBadRequest()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $product = factory(Product::class)->create([
            'lm' => '123456',
            'name' => 'First Product',
            'price' => 100.0
        ]);

        $payload = [
            'name' => 'Updated product',
            'price' => 'text on price'
        ];

        $response = $this->json('PUT', '/api/products/' . $product->id, $payload, $headers)
            ->assertStatus(400);
    }
}
