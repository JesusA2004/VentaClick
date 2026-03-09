<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Producto_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                ->constrained('Productos')
                ->cascadeOnDelete();
            $table->foreignId('sucursal_id')
                ->constrained('Sucursals')
                ->cascadeOnDelete();
            $table->decimal('stock_actual', 12, 2)->default(0);
            $table->decimal('stock_reservado', 12, 2)->default(0);
            $table->timestamps();
            $table->unique(['producto_id', 'sucursal_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Producto_stocks');
    }

};
