<?php

namespace Database\Seeders;

use App\Models\SparePart;
use Illuminate\Database\Seeder;

class SparePartSeeder extends Seeder
{
    public function run(): void
    {
        $spareParts = [
            [
                'part_name' => 'Phone Screen Replacement',
                'category' => 'Phone',
                'unit_price' => 180.00,
                'stock_quantity' => 10,
            ],
            [
                'part_name' => 'Phone Battery Replacement',
                'category' => 'Phone',
                'unit_price' => 120.00,
                'stock_quantity' => 15,
            ],
            [
                'part_name' => 'Charging Port Replacement',
                'category' => 'Phone',
                'unit_price' => 90.00,
                'stock_quantity' => 12,
            ],
            [
                'part_name' => 'Laptop Keyboard Replacement',
                'category' => 'Laptop',
                'unit_price' => 150.00,
                'stock_quantity' => 8,
            ],
            [
                'part_name' => 'Laptop RAM 8GB',
                'category' => 'Laptop',
                'unit_price' => 160.00,
                'stock_quantity' => 6,
            ],
            [
                'part_name' => 'Laptop SSD 256GB',
                'category' => 'Laptop',
                'unit_price' => 220.00,
                'stock_quantity' => 5,
            ],
        ];

        foreach ($spareParts as $sparePart) {
            SparePart::updateOrCreate(
                ['part_name' => $sparePart['part_name']],
                $sparePart
            );
        }
    }
}