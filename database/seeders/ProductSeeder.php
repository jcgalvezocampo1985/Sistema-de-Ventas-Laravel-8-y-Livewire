<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

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
            'name' => 'Curso laravel',
            'barcode' => '75010065987',
            'cost' => 200,
            'price' => 350,
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'curso.jpg',
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Curso laravel',
            'barcode' => '75010065987',
            'cost' => 200,
            'price' => 350,
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'curso.jpg',
            'category_id' => 2
        ]);

        Product::create([
            'name' => 'Curso laravel',
            'barcode' => '75010065987',
            'cost' => 200,
            'price' => 350,
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'curso.jpg',
            'category_id' => 3
        ]);

        Product::create([
            'name' => 'Curso laravel',
            'barcode' => '75010065987',
            'cost' => 200,
            'price' => 350,
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'curso.jpg',
            'category_id' => 4
        ]);
    }
}