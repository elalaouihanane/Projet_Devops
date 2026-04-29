<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $articles = Article::all();

        if ($users->isEmpty() || $articles->isEmpty()) {
            return;
        }

        foreach ($articles as $article) {
            // Chaque article kayen fih 3-10 likes
            $likesCount = min(rand(3, 10), $users->count());
            $randomUsers = $users->random($likesCount);

            foreach ($randomUsers as $user) {
                Like::firstOrCreate([
                    'user_id' => $user->id,
                    'likeable_id' => $article->id,
                    'likeable_type' => Article::class,
                ]);
            }
        }
    }
}