<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semester_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('semester_id')->nullable();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('week_number');
            $table->decimal('planned_hours', 4, 1)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('course_id');
            $table->unique(['course_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semester_schedules');
    }
};
