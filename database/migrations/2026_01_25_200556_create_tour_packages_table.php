<?php

use App\Models\User;
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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->foreignIdFor(User::class)->index()->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->string('slug');

            //Tour Availability
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();

            $table->string('location')->nullable();
            $table->unsignedInteger('duration')->default(0);

            $table->mediumText('excerpt')->nullable();
            $table->longText('description')->nullable();

            $table->unsignedInteger('adults_count')->default(1);
            $table->unsignedInteger('children_count')->default(0);

            $table->booleanFields();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
