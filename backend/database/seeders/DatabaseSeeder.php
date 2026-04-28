<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,  // D'abord (pas de dépendances)
            UserSeeder::class,      // Ensuite (pas de dépendances)
            ArticleSeeder::class,
            LikeSeeder::class,      // Khtachin Users w Articles
            CommentSeeder::class,   // Khtachin Users w Articles
            FavoriteSeeder::class,  // Khtachin Users w Articles
            FollowSeeder::class,
        ]);
    }
}