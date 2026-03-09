<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Movimientos_inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                ->constrained('Productos')
                ->cascadeOnDelete();
            $table->foreignId('sucursal_id')
                ->constrained('Sucursals')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('Users')
                ->nullOnDelete();
            $table->enum('tipo', ['ENTRADA', 'SALIDA', 'AJUSTE', 'VENTA', 'DEVOLUCION'])->nullable();
            $table->decimal('cantidad', 12, 2);
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->timestamps();
            $table->index(['producto_id', 'sucursal_id']);
            $table->index(['tipo', 'created_at']);
            $table->index(['referencia_tipo', 'referencia_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Movimientos_inventarios');
    }

};
