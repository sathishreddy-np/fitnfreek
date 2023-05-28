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
        $age = range(1, 100);
        $gender = ['Male', 'Female', 'Kids'];

        Schema::create('slot_classifications', function (Blueprint $table) use($age,$gender) {
            $table->id();
            $table->foreignId('slot_id')->constrained()->cascadeOnDelete();
            $table->enum('allowed_gender', $gender);
            $table->enum('allowed_age_from', $age);
            $table->enum('allowed_age_to', $age);
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_classifications');
    }
};
