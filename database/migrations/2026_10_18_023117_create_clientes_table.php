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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('sector');
            $table->string('pais');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('logo')->nullable();
            // Asegúrate de que la tabla 'servicios' ya exista antes de ejecutar esta migración
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

