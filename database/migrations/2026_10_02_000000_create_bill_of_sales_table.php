<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill_of_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('draft');
            $table->json('data');
            $table->timestamps();

            $table->index(['car_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_of_sales');
    }
};
