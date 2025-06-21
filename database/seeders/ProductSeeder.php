<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
      
        Product::create([
            'name' => 'Diamond Ring',
            'description' => 'This is the description for Diamond Ring.',
            'price' => 1000,
            'image_path' => 'images/1.jpg', 
        ]);

        Product::create([
            'name' => 'Black Dress',
            'description' => 'This is the description for Black Dress.',
            'price' => 200,
            'image_path' => 'images/2.jpg',
        ]);

        Product::create([
            'name' => 'Red Dress',
            'description' => 'This is the description for Red Dress.',
            'price' => 300,
            'image_path' => 'images/3.jpg',
        ]);
        Product::create([
            'name' => 'Black T-shirt',
            'description' => 'This is the description for Black T-shirt.',
            'price' => 300,
            'image_path' => 'images/5.jpg',
        ]);
    }
}
