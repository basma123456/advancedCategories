<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main categories
        $men = Category::create(['name' => 'Men']);
        $women = Category::create(['name' => 'Women']);
        $kids = Category::create(['name' => 'Kids']);



        // Create subcategories
        $topsMen = $men->children()->create(['name' => 'Tops (Men)']);
        $trousersMen = $men->children()->create(['name' => 'Trousers (Men)']);
        $tshirtsMen = $topsMen->children()->create(['name' => 'T-shirts (Men)']);
        $shirtMen = $topsMen->children()->create(['name' => 'Shirt (Men)']);
        $shortsMen = $trousersMen->children()->create(['name' => 'shorts (Men)']);




        // Example for Women categories
        $topsWomen = $women->children()->create(['name' => 'Tops (Women)']);
        $tshirtsWomen = $topsWomen->children()->create(['name' => 'T-shirts (Women)']);
        $blouseWomen = $topsWomen->children()->create(['name' => 'Blouse (Women)']);
        $blouseLongWomen = $blouseWomen->children()->create(['name' => 'Blouse Long (Women)']);


        // Example for kids categories
        $topskids = $kids->children()->create(['name' => 'Tops (kids)']);
        $trouserkids = $kids->children()->create(['name' => 'Trousers (kids)']);
        $tshirtskids = $topskids->children()->create(['name' => 'T-shirts (kids)']);
        $shortkids = $trouserkids->children()->create(['name' => 'shorts (kids)']);


    }
}
