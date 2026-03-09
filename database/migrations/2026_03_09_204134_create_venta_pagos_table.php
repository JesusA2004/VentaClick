<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Venta_pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('venta_id')
                ->constrained('Ventas')
                ->cascadeOnDelete();
            $table->enum('metodo_pago', ['EFECTIVO', 'TARJETA', 'TRANSFERENCIA', 'QR', 'OTRO'])->nullable();
            $table->decimal('monto', 12, 2);
            $table->string('referencia', 120)->nullable();
            $table->timestamps();
            $table->index(['venta_id', 'metodo_pago']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Venta_pagos');
    }

};
