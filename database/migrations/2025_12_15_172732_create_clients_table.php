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
        Schema::create('clients', function (Blueprint $table) {
        $table->id();
        
        // Datos Personales
        $table->string('name');              // Nombre completo (Ej: Juan Perez)
        $table->string('ci_nit')->nullable(); // Carnet o NIT (opcional porque a veces no te lo dan)
        $table->string('phone')->nullable();  // Celular (Vital para cobrarles)
        
        // Ubicación (Importante para entregas o cobros)
        $table->string('address')->nullable(); // Dirección específica
        
        // Tipo de Cliente (Para tu sistema de créditos futuro)
        // Ejemplo: "minorista", "mayorista", "vip"
        $table->string('type')->default('minorista'); 
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
