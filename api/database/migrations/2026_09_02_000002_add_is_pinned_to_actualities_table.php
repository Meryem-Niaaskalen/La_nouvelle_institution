<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('actualities', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false)->after('is_visible');
            $table->index(['is_pinned', 'is_visible']);
        });
    }

    public function down(): void
    {
        Schema::table('actualities', function (Blueprint $table) {
            $table->dropIndex('actualities_is_pinned_is_visible_index');
            $table->dropColumn('is_pinned');
        });
    }
};
