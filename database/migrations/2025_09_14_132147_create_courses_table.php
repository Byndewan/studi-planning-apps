<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->string('name');
            $table->integer('sks');
            $table->integer('total_modules')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('semester_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
