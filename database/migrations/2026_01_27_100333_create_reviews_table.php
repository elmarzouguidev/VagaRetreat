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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->foreignIdFor(\App\Models\User::class)
                ->index()
                ->constrained()
                ->cascadeOnDelete();

            $table->morphs('reviewable');

            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('comment')->nullable();
            
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
