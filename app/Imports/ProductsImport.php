<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class ProductsImport implements ToCollection, WithHeadingRow, WithEvents, WithMultipleSheets
{
    use Importable, RegistersEventListeners;
    use WithConditionalSheets;

    public static $category;

    /**
    * @param Collection $rows
    *
    * @return \Illuminate\Database\Eloquent\Collections
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Product::create([
                'im'  => $row['lm'],
                'name' => $row['name'],
                'free_shipping' => $row['free_shipping'] == 1 ? true : false,
                'description' => $row['description'],
                'price' => $row['price'],
                'category' => self::$category
            ]);
        }
    }

    public static function beforeImport(BeforeImport $event)
    {
        self::$category = $event->reader->getActiveSheet()->getCell('B1')->getValue();
    }

    public function conditionalSheets(): array
    {
        return [
            'Plan1' => new ProductsImport()
        ];
    }

    public function headingRow(): int
    {
        return 3;
    }
}

