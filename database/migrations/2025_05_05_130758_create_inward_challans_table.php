<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inward_challans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('challan_number')->unique();
            $table->string('main_challan_number');
            $table->date('date');
            $table->foreignId('purpose_id')->constrained('purposes')->onDelete('restrict');
            $table->text('notes')->nullable();

            // Industry details
            $table->string('industry_name');
            $table->string('industry_number')->nullable();
            $table->string('industry_gstin')->nullable();

            // Quantity summaries
            $table->decimal('total_qty', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inward_challans');
    }
};

