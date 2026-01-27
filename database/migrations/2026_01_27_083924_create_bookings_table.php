<?php

use App\Models\User;
use App\Enums\Booking\BookingStatusEnums;
use App\Models\Utilities\Price;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->morphs('bookable');
            $table->foreignIdFor(User::class,'customer_id')
            ->index()
            ->nullable()
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignIdFor(Price::class)
            ->index()
            ->nullable()
            ->constrained()
            ->cascadeOnDelete();

            $table->string('booking_reference')->unique();

            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_country')->nullable();

            $table->date('booking_date');
            $table->string('status',20)->default(BookingStatusEnums::PENDING->value);

            $table->booleanFields();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
