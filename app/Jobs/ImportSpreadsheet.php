<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Imtigger\LaravelJobStatus\Trackable;

class ImportSpreadsheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;
    protected $file_url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_url)
    {
        $this->prepareStatus();
        $this->file_url = $file_url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = $this->saveFile($this->file_url);
        $import = new ProductsImport();
        $import->onlySheets('Plan1');
        Excel::import($import, $filename);
    }

    private function saveFile($file_url)
    {
        $contents = file_get_contents($file_url);
        $name = substr($file_url, strrpos($file_url, '/') + 1);
        Storage::put($name, $contents);

        return $name;
    }
}
