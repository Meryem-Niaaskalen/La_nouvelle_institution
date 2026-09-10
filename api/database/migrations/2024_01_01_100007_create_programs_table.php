<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('level', ['elementaire', 'college', 'lycee'])->default('lycee');
            $table->text('description');
            $table->text('objectives')->nullable();
            $table->text('requirements')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->integer('duration_years')->default(1);
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['level', 'is_active']);
        });

        Schema::create('program_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->integer('hours_per_week')->default(3);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['program_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_subjects');
        Schema::dropIfExists('programs');
    }
};
