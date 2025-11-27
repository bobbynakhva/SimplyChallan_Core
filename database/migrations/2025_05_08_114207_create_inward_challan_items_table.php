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
        Schema::create('inward_challan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inward_challan_id')->constrained('inward_challans')->onDelete('cascade');
            $table->string('item_name');
            $table->decimal('qty', 10, 2);
            $table->integer('piece_no')->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inward_challan_items');
    }
};
