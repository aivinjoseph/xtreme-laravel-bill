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
            $table->string('technical_condition');
            $table->string('ext_color');
            $table->string('int_color');
            $table->string('make');
            $table->string('transmission');
            $table->string('model');
            $table->string('body_type');
            $table->string('drive');
            $table->string('door');
            $table->string('fuel');
            $table->string('trim');
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
