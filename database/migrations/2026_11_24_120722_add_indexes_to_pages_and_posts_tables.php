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
        Schema::table('pages', function (Blueprint $table) {
            $table->unique('slug');
            $table->unique('uuid');
            $table->index('published_at');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->unique('slug');
            $table->unique('uuid');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropUnique(['uuid']);
            $table->dropIndex(['published_at']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropUnique(['uuid']);
            $table->dropIndex(['published_at']);
        });
    }
};
