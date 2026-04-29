<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            // Clé primaire
            $table->id();

            // Relations
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Supprime les articles si l'utilisateur est supprimé

            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null'); // Garde l'article mais sans catégorie

            // Type de publication (obligatoire)
            $table->enum('type', ['outfit', 'clothing']);

            // Informations de base
            $table->string('title');                    // Titre/Nom de la publication
            $table->text('description')->nullable();    // Description détaillée

            // Spécifique aux LOOKS (outfit)
            $table->string('occasion')->nullable();     // casual, soirée, travail, sport...

            // Spécifique aux VÊTEMENTS (clothing)
            $table->string('color')->nullable();        // rouge, noir, bleu...

            // Média
            $table->string('image');                    // Chemin de la photo principale

            // Tags pour la recherche (EF18)
            $table->json('tags')->nullable();           // ["streetwear", "chic", "vintage"]

            // Statut de publication (EF13)
            $table->boolean('is_published')->default(true);

            // Compteurs sociaux (optimisation perf)
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);

            // Timestamps
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};