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
        Schema::create('sales', function (Blueprint $table) {
        $table->id();
        
        // Relación: Una venta pertenece a un Cliente
        $table->foreignId('client_id')->constrained()->onDelete('cascade');
        
        // Fecha de la venta (puede ser distinta a created_at si registras tarde)
        $table->date('sale_date')->default(now());
        
        // Estado: 'pagado' o 'pendiente' (VITAL para tus cobros)
        $table->string('status')->default('pagado'); 
        
        // El total de dinero de la nota
        $table->decimal('total', 10, 2)->default(0);
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
