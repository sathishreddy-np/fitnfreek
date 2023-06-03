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
        Schema::create('book_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->references('id')->on('companies');
            $table->foreignId('branch_id')->references('id')->on('branches');
            $table->string('name', 55);
            $table->integer('age');
            $table->string('gender', 55);
            $table->string('sport', 55);
            $table->string('slot_type', 55);
            $table->string('slot_name', 55);
            $table->bigInteger('starts_at_unix');
            $table->bigInteger('ends_at_unix');
            $table->integer('starts_at_hours');
            $table->integer('starts_at_minutes');
            $table->integer('ends_at_hours');
            $table->integer('ends_at_minutes');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_slots');
    }
};
