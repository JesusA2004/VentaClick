<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Caja_turnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')
                ->constrained('Cajas')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('Users')
                ->cascadeOnDelete();
            $table->dateTime('fecha_apertura');
            $table->dateTime('fecha_cierre')->nullable();
            $table->decimal('monto_inicial', 12, 2)->default(0);
            $table->decimal('monto_ventas_brutas', 12, 2)->default(0);
            $table->decimal('monto_descuentos', 12, 2)->default(0);
            $table->decimal('monto_final_calculado', 12, 2)->default(0);
            $table->decimal('monto_final_declarado', 12, 2)->nullable();
            $table->decimal('diferencia', 12, 2)->nullable();
            $table->enum('estado', ['ABIERTO', 'CERRADO', 'CANCELADO'])->default('ABIERTO');
            $table->timestamps();
            $table->index(['caja_id', 'estado']);
            $table->index(['user_id', 'estado']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Caja_turnos');
    }

};
