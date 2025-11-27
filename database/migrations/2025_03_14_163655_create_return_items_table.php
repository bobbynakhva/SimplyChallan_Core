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
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challan_item_id')->constrained()->onDelete('cascade');
            $table->date('despatch_date')->nullable();
            $table->decimal('quantity_returned', 10, 2)->nullable();
            $table->decimal('waste_scrap_returned', 10, 2)->nullable();
            $table->decimal('waste_not_recoverable', 10, 2)->nullable();
            $table->decimal('piece_returned', 10, 2)->nullable();
            $table->text('return_notes')->nullable();
            //$table->enum('status', ['pending', 'received', 'returned'])->default('pending')->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->decimal('remaining_qty', 10, 2)->nullable();
            $table->decimal('remaining_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
