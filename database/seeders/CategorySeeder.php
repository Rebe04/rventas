<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'CURSOS',
            'image' => 'https://dummyimage.com/200x150/8f8f8f/3e3e40'
        ]);
        Category::create([
            'name' => 'TENIS',
            'image' => 'https://dummyimage.com/200x150/8f8f8f/3e3e40'
        ]);
        Category::create([
            'name' => 'CELULARES',
            'image' => 'https://dummyimage.com/200x150/8f8f8f/3e3e40'
        ]);
        Category::create([
            'name' => 'COMPUTADORES',
            'image' => 'https://dummyimage.com/200x150/8f8f8f/3e3e40'
        ]);
    }
}
