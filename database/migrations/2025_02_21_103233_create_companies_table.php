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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('industry_name')->nullable();
            $table->string('industry_number')->nullable();
            $table->string('industry_gstin')->nullable();
            $table->string('industry_address')->nullable();

            $table->timestamps();           // created_at and updated_at
            $table->softDeletes();          // deleted_at for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
