<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'LARAVEL Y LIVEWIRE',
            'cost' => 200,
            'price' => 350,
            'barcode' => '7501002233654',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png',
        ]);
        Product::create([
            'name' => 'NIKE AIR',
            'cost' => 80000,
            'price' => 150000,
            'barcode' => '7501056233654',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 2,
            'image' => 'tenis.png',
        ]);
        Product::create([
            'name' => 'IPHONE 11',
            'cost' => 2500000,
            'price' => 3600000,
            'barcode' => '7508921033654',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 3,
            'image' => 'celu.png',
        ]);
        Product::create([
            'name' => 'ASUS TUF GAMING',
            'cost' => 2500000,
            'price' => 3600000,
            'barcode' => '75010964733654',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 4,
            'image' => 'compu.png',
        ]);
    }
}
