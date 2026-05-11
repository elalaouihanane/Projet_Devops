<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $users = [
            [
                'name' => 'Leila Boulam',
                'email' => 'leila@trendora.com',
                'password' => bcrypt('password'),
                'photo' => 'https://i.pravatar.cc/128?u=leila-trendora',
                'bio' => 'Passionnée de mode streetwear',
                'style_prefere' => 'streetwear',
            ],
            [
                'name' => 'Nouhaila Boutazoult',
                'email' => 'nouhaila@trendora.com',
                'password' => bcrypt('password'),
                'photo' => 'https://i.pravatar.cc/128?u=nouhaila-trendora',
                'bio' => 'J\'adore les looks vintage',
                'style_prefere' => 'vintage',
            ],
            [
                'name' => 'Hanane El Alaoui',
                'email' => 'hanane@trendora.com',
                'password' => bcrypt('password'),
                'photo' => 'https://i.pravatar.cc/128?u=hanane-trendora',
                'style_prefere' => 'casual',
            ],
            [
                'name' => 'Maryam Anahir',
                'email' => 'maryam@trendora.com',
                'password' => bcrypt('password'),
                'photo' => 'https://i.pravatar.cc/128?u=maryam-trendora',
                'style_prefere' => 'chic',
            ],
            [
                'name' => 'Samira Ouiming',
                'email' => 'samira@trendora.com',
                'password' => bcrypt('password'),
                'photo' => 'https://i.pravatar.cc/128?u=samira-trendora',
                'style_prefere' => 'sport',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}