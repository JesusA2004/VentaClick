<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')
                ->unique()
                ->constrained('Ventas')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('Users')
                ->cascadeOnDelete();
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('Clientes')
                ->nullOnDelete();
            $table->string('serie', 25)->nullable();
            $table->string('folio', 50)->nullable();
            $table->string('uuid', 50)->nullable();
            $table->enum('estado_timbrado', ['BORRADOR', 'TIMBRADA', 'CANCELADA', 'ERROR'])->default('BORRADOR');
            $table->string('rfc_receptor', 20);
            $table->string('nombre_receptor', 255);
            $table->string('regimen_fiscal_receptor', 10);
            $table->string('codigo_postal_receptor', 10);
            $table->string('uso_cfdi', 10);
            $table->string('forma_pago', 5)->nullable();
            $table->string('metodo_pago', 5)->nullable();
            $table->decimal('subtotal', 12, 2)->nullable();
            $table->decimal('descuento', 12, 2)->nullable();
            $table->decimal('impuestos', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->longText('xml_timbrado')->nullable();
            $table->string('pdf_url', 255)->nullable();
            $table->dateTime('fecha_timbrado')->nullable();
            $table->timestamps();
            $table->unique('uuid');
            $table->index(['estado_timbrado', 'fecha_timbrado']);
            $table->index('rfc_receptor');
        });
    }

    public function down(): void {
        Schema::dropIfExists('Facturas');
    }

};
