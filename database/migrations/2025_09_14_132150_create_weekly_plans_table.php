<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('week_number');
            $table->text('target_text');
            $table->integer('num_pages')->default(0);
            $table->json('media')->nullable();
            $table->decimal('planned_hours', 4, 1)->default(0);
            $table->enum('status', ['planned', 'in_progress', 'completed', 'missed'])->default('planned');
            $table->timestamps();

            $table->index('course_id');
            $table->unique(['course_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_plans');
    }
};
