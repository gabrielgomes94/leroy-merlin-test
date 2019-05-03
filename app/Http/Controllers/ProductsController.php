<?php

namespace App\Http\Controllers;

use App\Product;
use App\Imports\ProductsImport;
use App\Jobs\ImportSpreadsheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Imtigger\LaravelJobStatus\JobStatus;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $job = new ImportSpreadsheet($request->input('file_url'));

        $jobStatusId = $job->getJobStatusId();

        dispatch($job);

        $link = 'http://localhost:8000/api/products/import_status/'.$jobStatusId;
        return response()->json('Spreadsheet is being imported. Check its status on:'.$link, 201);
    }

    public function import_status($job_status_id)
    {
        $jobStatus = JobStatus::findOrFail($job_status_id);

        if ($jobStatus->is_finished == true){
            $message = 'Spreadsheet was successfully imported!';
            $status_code = 201;
        } elseif ($jobStatus->is_failed ==true){

            $message = ['message' => 'Spreadsheet could not be imported.',
                'errors ' => $jobStatus->output,
                'attempts' => $jobStatus->attempts];
            $status_code = 500;
        } else {
            $message = 'Spreadsheet still being imported.';
            $status_code = 200;
        }

        return response()->json($message, $status_code);

    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response()->json($product, 200);
    }

}
