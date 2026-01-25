<?php

use App\Models\Tour\TourPackage;
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
        Schema::create('tour_package_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->foreignIdFor(TourPackage::class)->index()->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->string('slug');

            $table->date('plan_date')->nullable();
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();

            $table->mediumText('excerpt')->nullable();
            $table->longText('description')->nullable();

            $table->booleanFields();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_plans');
    }
};
