<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
Schema::create('teacher_availabilities', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->string('language', 50);
    $table->date('date');
    $table->time('start_time');
    $table->time('end_time');

    // ✅ nom d’index COURT
    $table->unique(
        ['user_id', 'language', 'date', 'start_time', 'end_time'],
        'uniq_teacher_availability'
    );

    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_availabilities');
    }
};
