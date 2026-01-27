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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->foreignIdFor(TourPackage::class)
                ->index()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->unsignedInteger('capacity')->default(1);
            $table->unsignedInteger('quantity')->default(1);
            $table->text('description')->nullable();
            
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
