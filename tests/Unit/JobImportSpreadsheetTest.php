<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ImportSpreadsheet;

class JobImportSpreadsheetTest extends TestCase
{

    public function testJobImportSpreadsheet()
    {
        Excel::fake();

        $path = storage_path("app/public/products_teste_webdev_leroy.xlsx", 'public');
        $job = new ImportSpreadsheet($path);
        $job->handle();

        Excel::assertImported('products_teste_webdev_leroy.xlsx');
    }
}
