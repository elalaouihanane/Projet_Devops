<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $articles = Article::all();

        if ($users->isEmpty() || $articles->isEmpty()) {
            return;
        }

        foreach ($articles as $article) {
            // 2-5 comments principaux 3la chaque article
            $commentsCount = rand(2, 5);

            for ($i = 0; $i < $commentsCount; $i++) {
                $comment = Comment::create([
                    'user_id' => $users->random()->id,
                    'commentable_id' => $article->id,
                    'commentable_type' => Article::class,
                    'parent_id' => null,
                    'content' => fake()->paragraph(2),
                ]);

                // 0-2 replies 3la chaque comment
                $repliesCount = rand(0, 2);
                for ($j = 0; $j < $repliesCount; $j++) {
                    Comment::create([
                        'user_id' => $users->random()->id,
                        'commentable_id' => $article->id,
                        'commentable_type' => Article::class,
                        'parent_id' => $comment->id,
                        'content' => fake()->sentence(8),
                    ]);
                }
            }
        }
    }
}