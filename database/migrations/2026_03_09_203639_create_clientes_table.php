<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('telefono', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('rfc', 20)->nullable();
            $table->string('nombre_fiscal', 255)->nullable();
            $table->string('regimen_fiscal', 10)->nullable();
            $table->string('codigo_postal_fiscal', 10)->nullable();
            $table->string('uso_cfdi_default', 10)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->index('rfc');
            $table->index('email');
        });
    }

    public function down(): void {
        Schema::dropIfExists('Clientes');
    }

};
