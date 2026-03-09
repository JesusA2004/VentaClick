<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')
                ->constrained('Sucursals')
                ->cascadeOnDelete();
            $table->foreignId('caja_id')
                ->constrained('Cajas')
                ->cascadeOnDelete();
            $table->foreignId('caja_turno_id')
                ->constrained('Caja_turnos')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('Users')
                ->cascadeOnDelete();
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('Clientes')
                ->nullOnDelete();
            $table->foreignId('descuento_id')
                ->nullable()
                ->constrained('Descuentos')
                ->nullOnDelete();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('descuento_total', 12, 2)->default(0);
            $table->decimal('impuesto_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->decimal('total_pagado', 12, 2)->nullable();
            $table->decimal('cambio', 12, 2)->nullable();
            $table->enum('estado', ['COMPLETADA', 'CANCELADA', 'DEVUELTA'])->default('COMPLETADA');
            $table->timestamps();
            $table->index(['sucursal_id', 'created_at']);
            $table->index(['caja_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['estado', 'created_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Ventas');
    }

};
