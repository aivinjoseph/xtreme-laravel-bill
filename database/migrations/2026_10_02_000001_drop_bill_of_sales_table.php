<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('bill_of_sales');
    }

    public function down(): void
    {
        // Bill of Sale transactions are intentionally temporary and are not recreated.
    }
};
