<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_categories', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('gallery_categories', 'order')) {
                $table->integer('order')->default(0);
            }
            if (!Schema::hasColumn('gallery_categories', 'is_visible')) {
                $table->boolean('is_visible')->default(true);
            }
        });

        Schema::table('gallery_images', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_images', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('gallery_images', 'thumbnail')) {
                $table->string('thumbnail')->nullable();
            }
            if (!Schema::hasColumn('gallery_images', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('gallery_images', 'order')) {
                $table->integer('order')->default(0);
            }
            if (!Schema::hasColumn('gallery_images', 'is_visible')) {
                $table->boolean('is_visible')->default(true);
            }
        });

    }

    public function down(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_images', 'is_visible')) {
                $table->dropColumn('is_visible');
            }
            if (Schema::hasColumn('gallery_images', 'order')) {
                $table->dropColumn('order');
            }
            if (Schema::hasColumn('gallery_images', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('gallery_images', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
            if (Schema::hasColumn('gallery_images', 'image')) {
                $table->dropColumn('image');
            }
        });

        Schema::table('gallery_categories', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_categories', 'is_visible')) {
                $table->dropColumn('is_visible');
            }
            if (Schema::hasColumn('gallery_categories', 'order')) {
                $table->dropColumn('order');
            }
            if (Schema::hasColumn('gallery_categories', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
