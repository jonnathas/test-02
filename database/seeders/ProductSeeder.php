<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'PF',
            'price' => 30,
        ]);

        Product::create([
            'name' => 'Água',
            'price' => 4,
        ]);

        Product::create([
            'name' => 'Refrigerante',
            'price' => 10,
        ]);

        Product::create([
            'name' => 'Cerveja',
            'price' => 8,
        ]);

        Product::create([
            'name' => 'Brigadeiro',
            'price' => 2,
        ]);
    }
}
