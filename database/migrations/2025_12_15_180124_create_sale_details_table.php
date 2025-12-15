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
        Schema::create('sale_details', function (Blueprint $table) {
        $table->id();
        
        // Relación con la Venta
        $table->foreignId('sale_id')->constrained()->onDelete('cascade');
        
        // Relación con el Producto
        $table->foreignId('product_id')->constrained();
        
        // Datos de la transacción
        $table->integer('quantity'); // Cuántos llevó
        $table->decimal('price', 10, 2); // A qué precio se lo diste (puede variar del precio de lista)
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
