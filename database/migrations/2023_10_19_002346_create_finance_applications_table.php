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
        Schema::create('finance_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('sin')->nullable();
            $table->date('dob');
            $table->string('marital_status');
            $table->string('license_number');
            $table->date('license_expiry');

            // Address information
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->string('residence_type');
            $table->integer('rent_mortgage_amount');

            // Employment information
            $table->string('employer');
            $table->string('employer_phone');
            $table->string('job_title');
            $table->string('job_length');
            $table->string('income_amount');
            $table->string('income_frequency');
            $table->string('employer_address');

            // Co-applicant information
            $table->json('co_applicant')->nullable();

            // Trade-in information
            $table->json('trade_in')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_applications');
    }
};
