<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
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
            'image' => 'https://dummyimage.com/200x150/707070/fff.jpg'
        ]);

        Category::create([
            'name' => 'TENIS',
            'image' => 'https://dummyimage.com/200x150/707070/fff.jpg'
        ]);

        Category::create([
            'name' => 'CELULARES',
            'image' => 'https://dummyimage.com/200x150/707070/fff.jpg'
        ]);

        Category::create([
            'name' => 'COMPUTADORAS',
            'image' => 'https://dummyimage.com/200x150/707070/fff.jpg'
        ]);
    }
}