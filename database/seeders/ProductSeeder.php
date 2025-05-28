<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            ['name' => 'iPhone 15', 'price' => 999.99, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung Galaxy S24', 'price' => 899.99, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'OnePlus 12', 'price' => 749.99, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Google Pixel 9', 'price' => 799.99, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

