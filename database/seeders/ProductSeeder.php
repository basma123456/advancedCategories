<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve categories
        $categories = Category::all();

         for ($i = 1; $i <= 20; $i++) { // Example: Create 20 products
            $product = Product::create([
                'name' => 'Product ' . $i,
                'description' => 'Description of Product ' . $i,
                'price' => rand(10, 100),
            ]);

            // Attach random categories to the product
//            $product->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());
        }
    }


}
