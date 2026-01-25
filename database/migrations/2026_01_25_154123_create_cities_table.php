<?php

use App\Models\Utilities\Country;
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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            
            $table->string('name');
            $table->string('slug')->unique();

            $table->foreignIdFor(Country::class)->index()->nullable()->constrained()->nullOnDelete();


            $table->booleanFields();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
