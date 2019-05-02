<?php

namespace App\Http\Controllers;

use App\Product;
use App\Imports\ProductsImport;
use App\Jobs\ImportSpreadsheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    public function store(Request $request)
    {
        dispatch(new ImportSpreadsheet($request->input('file_url')));

        return response()->json('A planilha está sendo importada.', 201);
    }
}
