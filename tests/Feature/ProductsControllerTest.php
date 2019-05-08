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
}