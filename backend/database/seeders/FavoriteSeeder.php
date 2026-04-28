<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $articles = Article::all();

        if ($users->isEmpty() || $articles->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Chaque user kayen 3ndou 2-5 favorites
            $favoritesCount = min(rand(2, 5), $articles->count());
            $randomArticles = $articles->random($favoritesCount);

            foreach ($randomArticles as $article) {
                Favorite::firstOrCreate([
                    'user_id' => $user->id,
                    'favoritable_id' => $article->id,
                    'favoritable_type' => Article::class,
                ]);
            }
        }
    }
}