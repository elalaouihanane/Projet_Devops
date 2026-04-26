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
            ArticleSeeder::class,   // En dernier (besoin de users et categories)
        ]);
    }
}