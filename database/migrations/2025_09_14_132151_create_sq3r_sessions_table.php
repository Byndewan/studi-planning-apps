<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sq3r_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('module_title');
            $table->text('survey_notes')->nullable();
            $table->json('questions')->nullable();
            $table->text('read_notes')->nullable();
            $table->text('recite_notes')->nullable();
            $table->text('review_notes')->nullable();
            $table->json('timestamps')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sq3r_sessions');
    }
};
