<?php

namespace Database\Seeders;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            return;
        }

        foreach ($users as $user) {
            // Chaque user kayfollowi 3-7 users
            $potentialFollowing = $users->where('id', '!=', $user->id);

            if ($potentialFollowing->isEmpty()) {
                continue;
            }

            $followsCount = min(rand(3, 7), $potentialFollowing->count());
            $following = $potentialFollowing->random($followsCount);

            foreach ($following as $followedUser) {
                Follow::firstOrCreate([
                    'follower_id' => $user->id,
                    'following_id' => $followedUser->id,
                ]);
            }
        }
    }
}