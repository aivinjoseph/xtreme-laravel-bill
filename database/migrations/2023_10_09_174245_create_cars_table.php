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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('technical_condition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ext_color_id')->constrained('colors')->cascadeOnDelete();
            $table->foreignId('int_color_id')->constrained('colors')->cascadeOnDelete();
            $table->foreignId('manufacturer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transmission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_model_id')->constrained()->cascadeOnDelete();
            $table->foreignId('body_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drive_id')->constrained()->cascadeOnDelete();
            $table->foreignId('door_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fuel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trim_id')->constrained()->cascadeOnDelete();
            $table->longText('description');
            $table->string('availability');
            $table->integer('mileage');
            $table->integer('price');
            $table->integer('engine');
            $table->integer('seats');
            $table->json('features');
            $table->integer('year');
            $table->json('images');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
