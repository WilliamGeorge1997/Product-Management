<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\App\Models\Product;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'This is product 1',
                'price' => 100,
                'quantity' => 10,
            ],
            [
                'name' => 'Product 2',
                'description' => 'This is product 2',
                'price' => 200,
                'quantity' => 20,
            ],
            [
                'name' => 'Product 3',
                'description' => 'This is product 3',
                'price' => 300,
                'quantity' => 30,
            ],
            [
                'name' => 'Product 4',
                'description' => 'This is product 4',
                'price' => 400,
                'quantity' => 40,
            ],
            [
                'name' => 'Product 5',
                'description' => 'This is product 5',
                'price' => 500,
                'quantity' => 50,
            ],
            [
                'name' => 'Product 6',
                'description' => 'This is product 6',
                'price' => 600,
                'quantity' => 60,
            ],
            [
                'name' => 'Product 7',
                'description' => 'This is product 7',
                'price' => 700,
                'quantity' => 70,
            ],
            [
                'name' => 'Product 8',
                'description' => 'This is product 8',
                'price' => 800,
                'quantity' => 80,
            ],
            [
                'name' => 'Product 9',
                'description' => 'This is product 9',
                'price' => 900,
                'quantity' => 90,
            ],
            [
                'name' => 'Product 10',
                'description' => 'This is product 10',
                'price' => 1000,
                'quantity' => 100,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
