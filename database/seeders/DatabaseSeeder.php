<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::create(
            [
                'name' => 'bier1',
                'description' => 'een lekker biertje',
                'price' => 10,
                'category' => 'IPA'
            ],

            [
                'name' => 'bier2',
                'description' => 'nog een lekker biertje',
                'price' => 8,
                'category' => 'Wit'
            ],

            [
                'name' => 'bier3',
                'description' => 'weer een lekker biertje',
                'price' => 5,
                'category' => 'Blond'
            ]);
    }
}
