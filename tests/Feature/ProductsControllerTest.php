<?php
namespace Tests\Feature;

use App\Product;
use App\Imports\ProductsImport;
use App\Jobs\ImportSpreadsheet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

class ProductsControllerTest extends TestCase
{
    public function testsProductsImportJobAreCreatedCorrectly()
    {
        Queue::fake();
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $payload = [
            'file_url' => 'http://spreadsheet.xslx',
        ];

        $response = $this->json('POST', '/api/products/', $payload, $headers)
            ->assertStatus(201);

        Queue::assertPushed(ImportSpreadsheet::class, 1);
    }

}