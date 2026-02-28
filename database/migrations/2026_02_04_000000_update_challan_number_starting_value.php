<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set AUTO_INCREMENT to 634
        // Note: For MySQL/MariaDB
        DB::statement("ALTER TABLE challans AUTO_INCREMENT = 634");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We generally don't want to lower AUTO_INCREMENT as it might cause collisions
    }
};
