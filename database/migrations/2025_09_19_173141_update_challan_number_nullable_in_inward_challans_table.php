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
        Schema::table('inward_challans', function (Blueprint $table) {
            $table->string('challan_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inward_challans', function (Blueprint $table) {
            $table->string('challan_number')->nullable(false)->change(); // revert back to NOT NULL
        });
    }
};
