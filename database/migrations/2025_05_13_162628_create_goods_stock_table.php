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
        Schema::create('goods_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inward_challan_items_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->decimal('kgs', 10, 2)->default(0);
            $table->integer('pcs')->default(0);
            $table->decimal('remaining_qty', 10, 2)->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_stock');
    }
};
