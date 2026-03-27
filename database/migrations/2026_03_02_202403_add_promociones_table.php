<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('admin_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Admin que registró el pago');

            $table->integer('dias_pagados');
            $table->decimal('monto', 8, 2)->nullable()->comment('Monto pagado (opcional)');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->text('notas')->nullable()->comment('Notas del admin sobre el pago');

            $table->timestamps();

            // Índice para agilizar la consulta más frecuente:
            // WHERE user_id = ? AND fecha_fin >= TODAY
            $table->index(['user_id', 'fecha_fin']);
            $table->index('fecha_fin'); // para la query del welcome
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promociones');
    }
};