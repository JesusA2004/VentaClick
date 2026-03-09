<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                ->nullable()
                ->constrained('Categorias')
                ->nullOnDelete();
            $table->string('codigo_barras', 120)->nullable()->unique();
            $table->string('codigo_qr', 120)->nullable()->unique();
            $table->string('sku', 80)->nullable()->unique();
            $table->string('nombre', 160);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_compra', 12, 2)->default(0);
            $table->decimal('precio_venta', 12, 2);
            $table->decimal('impuesto_porcentaje', 5, 2)->default(0);
            $table->boolean('permite_descuento')->default(true);
            $table->decimal('stock_minimo', 12, 2)->default(0);
            $table->string('unidad_medida', 30)->default('PZA');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->index('nombre');
        });
    }

    public function down(): void {
        Schema::dropIfExists('Productos');
    }

};
