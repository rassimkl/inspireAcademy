<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1️⃣ Table des langues
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // ex: English, Spanish, French
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2️⃣ Table des niveaux
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex: A1, B1, C2
            $table->string('description')->nullable(); // ex: "Débutant", "Intermédiaire"
            $table->timestamps();
        });

        // 3️⃣ Table des cours en ligne
        Schema::create('online_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path'); // chemin du fichier PDF
            $table->unsignedBigInteger('created_by')->nullable(); // admin ou auteur
            $table->timestamps();

            // Relation vers l'utilisateur qui a créé le cours
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_courses');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('languages');
    }
};
