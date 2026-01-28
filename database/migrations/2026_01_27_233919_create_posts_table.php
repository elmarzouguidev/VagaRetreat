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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->foreignIdFor(User::class, 'author_id')->nullable()->index()->constrained()->nullOnDelete();

            $table->string('title');
            $table->string('slug');

            $table->mediumText('excerpt')->nullable();
            $table->longText('body')->nullable();
            
            $table->date('published_at')->nullable();

            $table->booleanFields();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
