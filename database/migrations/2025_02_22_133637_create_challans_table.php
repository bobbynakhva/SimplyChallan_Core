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
        Schema::create('challans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('financial_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('challan_number')->unique();
            $table->date('date');
            $table->foreignId('purpose_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();

            $table->string('industry_name')->nullable();
            $table->string('industry_number')->nullable();
            $table->string('industry_gstin')->nullable();
            $table->text('industry_address')->nullable();


            $table->string('vehicle_no')->nullable();
            $table->string('no_of_packages')->nullable();

            /*$table->string('item_name')->nullable();
            $table->string('hsn_code')->nullable();
            $table->decimal('price_per_kg', 10, 2)->default(0);
            $table->decimal('total_qty', 10, 3)->default(0);
            $table->decimal('total_value', 12, 2)->default(0);*/

            $table->decimal('cgst', 5, 2)->default(0);
            $table->decimal('sgst', 5, 2)->default(0);
            $table->decimal('total_tax', 10, 2);
            $table->decimal('grand_total', 12, 2)->default(0);
            
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challans');
        $table->dropSoftDeletes();
    }
};
