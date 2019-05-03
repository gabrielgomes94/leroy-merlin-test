<?php
namespace Tests\Feature;

use App\Product;
use App\Imports\ProductsImport;
use App\Jobs\ImportSpreadsheet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Imtigger\LaravelJobStatus\JobStatus;

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

    public function testsProductsCheckImportStatusWhenJobFinished()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $status = 'finished';
        $job_status_id = JobStatus::create(['type' => 'App\Jobs\ImportSpreadsheet', 'status'=>$status])->id;
        $response = $this->json('GET', '/api/products/import_status/'.$job_status_id, [], $headers)
            ->assertStatus(201);
    }

    public function testsProductsCheckImportStatusWhenJobFailed()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $status = 'failed';

        $job_status_id = JobStatus::create(['type' => 'App\Jobs\ImportSpreadsheet', 'status'=>$status])->id;
        $response = $this->json('GET', '/api/products/import_status/'.$job_status_id, [], $headers)
            ->assertStatus(500);
    }

    public function testsProductsCheckImportStatusWhenJobQueuedOrExecuting()
    {
        $auth_token = "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq";
        $headers = ['Authorization' => "$auth_token"];

        $status = 'queued';
        $job_status_id = JobStatus::create(['type' => 'App\Jobs\ImportSpreadsheet', 'status'=>$status])->id;
        $response = $this->json('GET', '/api/products/import_status/'.$job_status_id, [], $headers)
            ->assertStatus(200);

        $status = 'executing';
        $job_status_id = JobStatus::create(['type' => 'App\Jobs\ImportSpreadsheet', 'status'=>$status])->id;
        $response = $this->json('GET', '/api/products/import_status/'.$job_status_id, [], $headers)
            ->assertStatus(200);
    }

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
}
