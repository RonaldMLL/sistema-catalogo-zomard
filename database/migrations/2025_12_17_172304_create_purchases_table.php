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
        Schema::create('purchases', function (Blueprint $table) {
        $table->id();
        
        // Relaciones
        $table->foreignId('provider_id')->constrained(); // A quién le compramos
        $table->foreignId('product_id')->constrained();  // Qué compramos
        
        // Datos de la compra
        $table->integer('quantity');            // Cuántos llegaron
        $table->decimal('unit_cost', 10, 2);    // Cuánto costó cada uno (en Bs o $)
        $table->date('purchase_date');          // Fecha de llegada
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
