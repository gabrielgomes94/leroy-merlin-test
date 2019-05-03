<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiAuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApiAuthToken()
    {
        $response = $this->withHeaders(['Authorization' => 'p2lbgWkFrykA4QyUmpHihzmc5BNzIABq',])
            ->json('GET', '/api/products')
            ->assertStatus(200);

        $response = $this->withHeaders(['Authorization' => 'anything',])
            ->json('GET', '/api/products')
            ->assertStatus(401);
    }
}
