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
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        
        $table->string('name');             // Nombre del producto
        $table->text('description')->nullable(); // Descripción (puede estar vacía)
        
        // DECIMAL: Para dinero. (10 dígitos en total, 2 decimales)
        // Ejemplo: 99999999.99
        $table->decimal('price', 10, 2);    
        
        $table->integer('stock');           // Cantidad disponible
        
        // STRING: Aquí guardaremos la "ruta" o el nombre del archivo de la imagen
        // nullable() porque quizás al principio no subas foto
        $table->string('image_path')->nullable(); 
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
