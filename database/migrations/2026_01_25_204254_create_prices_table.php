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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->morphs('priceable');

            $table->string('name')->nullable();
            $table->string('slug')->nullable();

            $table->unsignedBigInteger('amount')->default(0)->comment('Amount in smallest currency unit (e.g., cents)');

            $table->string('currency', 3); // ISO 4217 currency codes are 3 chars

            $table->dateTime('expired_at')->nullable()->index();

            $table->json('options')->nullable();

            $table->booleanFields();
            $table->timestamps();

            $table->index(['priceable_type', 'priceable_id', 'currency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
