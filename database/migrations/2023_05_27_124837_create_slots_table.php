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

        $hours = range(0, 23);
        $minutes = range(0, 60);
        $slot_types = ['One-time', 'Subscription'];
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $sports = ['Swimming', 'Gym', 'Cricket', 'Badminton', 'Tennis'];
        $no_of_slots = range(0, 1000);

        Schema::create('slots', function (Blueprint $table) use ($hours, $minutes, $days, $slot_types, $sports, $no_of_slots) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->enum('sport', $sports);
            $table->enum('slot_type', $slot_types);
            $table->string('slot_name', 55);
            $table->integer('days_of_plan');
            $table->integer('no_of_times_allowed');
            $table->enum('day', $days);
            $table->enum('no_of_slots', $no_of_slots);
            $table->enum('starts_at_hours', $hours);
            $table->enum('starts_at_minutes', $minutes);
            $table->enum('ends_at_hours', $hours);
            $table->enum('ends_at_minutes', $minutes);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
