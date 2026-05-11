<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Article::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $users = User::all();
        $categories = Category::all();

        // Looks (Outfits)
        Article::create([
            'user_id' => $users->random()->id,
            'category_id' => null, // Les looks n'ont pas de catégorie
            'type' => 'outfit',
            'title' => 'Tenue casual weekend',
            'description' => 'Look décontracté pour une sortie entre amis',
            'occasion' => 'casual',
            'color' => null,
            'image' => 'https://picsum.photos/seed/outfit1/600/800',
            'tags' => ['streetwear', 'décontracté', 'été'],
            'is_published' => true,
        ]);

        Article::create([
            'user_id' => $users->random()->id,
            'category_id' => null,
            'type' => 'outfit',
            'title' => 'Soirée élégante',
            'description' => 'Tenue chic pour une soirée',
            'occasion' => 'soirée',
            'image' => 'https://picsum.photos/seed/outfit2/600/800',
            'tags' => ['chic', 'soirée', 'élégant'],
            'is_published' => true,
        ]);

        // Vêtements (Clothing)
        Article::create([
            'user_id' => $users->random()->id,
            'category_id' => $categories->where('slug', 'veste')->first()->id,
            'type' => 'clothing',
            'title' => 'Veste en cuir noir',
            'description' => 'Veste en cuir véritable, très bon état',
            'occasion' => null,
            'color' => 'noir',
            'image' => 'https://picsum.photos/seed/veste1/600/800',
            'tags' => ['vintage', 'cuir', 'rock'],
            'is_published' => true,
        ]);

        Article::create([
            'user_id' => $users->random()->id,
            'category_id' => $categories->where('slug', 'robe')->first()->id,
            'type' => 'clothing',
            'title' => 'Robe d\'été fleurie',
            'description' => 'Robe légère parfaite pour l\'été',
            'occasion' => null,
            'color' => 'multicolore',
            'image' => 'https://picsum.photos/seed/robe1/600/800',
            'tags' => ['été', 'fleurie', 'léger'],
            'is_published' => true,
        ]);

        Article::create([
            'user_id' => $users->random()->id,
            'category_id' => $categories->where('slug', 'chaussures')->first()->id,
            'type' => 'clothing',
            'title' => 'Baskets blanches',
            'description' => 'Baskets tendance confortables',
            'occasion' => null,
            'color' => 'blanc',
            'image' => 'https://picsum.photos/seed/baskets1/600/800',
            'tags' => ['sport', 'tendance', 'confort'],
            'is_published' => true,
        ]);
    }
}