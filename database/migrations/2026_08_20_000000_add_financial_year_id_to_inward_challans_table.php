<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('inward_challans', 'financial_year_id')) {
            Schema::table('inward_challans', function (Blueprint $table) {
                $table->foreignId('financial_year_id')->nullable()->after('user_id')->constrained('financial_years')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('inward_challans', 'financial_year_id')) {
            Schema::table('inward_challans', function (Blueprint $table) {
                $table->dropForeign(['financial_year_id']);
                $table->dropColumn('financial_year_id');
            });
        }
    }
};
