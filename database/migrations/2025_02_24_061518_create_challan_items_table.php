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
        Schema::create('challan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challan_id')->constrained()->onDelete('cascade');
            $table->string('subsidiary_challan_number')->nullable();
            $table->string('item_name');
            $table->string('hsn_code');
            $table->decimal('price_per_kg', 10, 3);
            $table->decimal('total_qty', 10, 2);
            $table->decimal('total_value', 10, 2);
            $table->integer('piece_no')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challan_items');
    }

    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class);
    }

};
