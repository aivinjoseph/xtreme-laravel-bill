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
            $table->string('slug')->unique();
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
            $table->string('mileage_unit');
            $table->integer('price');
            $table->string('engine');
            $table->string('seats');
            $table->json('features');
            $table->integer('year');
            $table->json('images');
            $table->string('video_link')->nullable();
            $table->integer('featured_image_index')->default(0);
            $table->boolean('featured')->default(false);
            $table->foreignId('user_id')->constrained();
            $table->softDeletes();
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
