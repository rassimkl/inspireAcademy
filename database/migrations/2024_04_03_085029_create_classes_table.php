<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('hours');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('status')->default(1)->comment('1: Not Completed, 2: Completed');
            $table->tinyInteger('payment_status')->default(1)->comment('1: Not Paid, 2: Paid');
            $table->string('report', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
