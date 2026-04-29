<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
{
    \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Category::truncate();
    \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $categories = [
        ['name' => 'Haut', 'slug' => 'haut'],
        ['name' => 'Pantalon', 'slug' => 'pantalon'],
        ['name' => 'Robe', 'slug' => 'robe'],
        ['name' => 'Jupe', 'slug' => 'jupe'],
        ['name' => 'Veste', 'slug' => 'veste'],
        ['name' => 'Chaussures', 'slug' => 'chaussures'],
        ['name' => 'Accessoires', 'slug' => 'accessoires'],
        ['name' => 'Costume', 'slug' => 'costume'],
    ];

    foreach ($categories as $cat) {
        Category::create($cat);
    }
}
}