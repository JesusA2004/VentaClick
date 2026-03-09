<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Descuentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->nullable()->unique();
            $table->string('nombre', 120)->nullable();
            $table->enum('tipo', ['PORCENTAJE', 'MONTO']);
            $table->decimal('valor', 12, 2);
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->integer('limite_usos')->nullable();
            $table->integer('usos_actuales')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->index(['activo', 'fecha_inicio', 'fecha_fin']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Descuentos');
    }

};
