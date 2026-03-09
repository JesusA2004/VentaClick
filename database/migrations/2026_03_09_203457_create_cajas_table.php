<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Cajas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')
                ->constrained('Sucursals')
                ->cascadeOnDelete();
            $table->string('nombre', 120);
            $table->string('clave', 30);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->unique(['sucursal_id', 'clave']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Cajas');
    }

};
