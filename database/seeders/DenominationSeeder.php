<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Denomination::create([
            'type' => 'Billete',
            'value' => 1000
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 500
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 200
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 100
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 50
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 20
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 20
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 10
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 5
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 2
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 1
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 0.5
        ]);

        Denomination::create([
            'type' => 'Otro',
            'value' => 0
        ]);
    }
}