<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Ex: "Haut", "Pantalon", "Robe", "Chaussures"
            $table->string('slug')->unique(); // URL-friendly: "haut", "pantalon", "robe"
            $table->string('icon')->nullable(); // Icône pour l'UI (optionnel)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};