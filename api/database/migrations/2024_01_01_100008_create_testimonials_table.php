<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->string('author_role');
            $table->text('content');
            $table->string('avatar')->nullable();
            $table->enum('testimonial_type', ['parent', 'student', 'former_student'])->default('parent');
            $table->integer('rating')->default(5);
            $table->boolean('is_published')->default(false);
            $table->boolean('featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'testimonial_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
