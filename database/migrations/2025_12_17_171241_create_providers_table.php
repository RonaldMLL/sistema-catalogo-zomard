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
        Schema::create('providers', function (Blueprint $table) {
        $table->id();
        $table->string('name');           // Nombre de la fábrica (ej: Shanghai Toilets Co.)
        $table->string('contact_name')->nullable(); // Nombre del contacto (ej: Mr. Li)
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('country')->default('China'); // País (por defecto China)
        $table->text('address')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
