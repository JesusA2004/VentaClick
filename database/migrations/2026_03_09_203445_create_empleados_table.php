<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('Users')
                ->nullOnDelete();
            $table->foreignId('sucursal_id')
                ->constrained('Sucursals')
                ->cascadeOnDelete();
            $table->string('numero_empleado', 30)->nullable()->unique();
            $table->string('nombre', 120);
            $table->string('apellido_paterno', 120)->nullable();
            $table->string('apellido_materno', 120)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('puesto', 100)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->enum('estatus', ['ACTIVO', 'INACTIVO', 'BAJA'])->default('ACTIVO');
            $table->decimal('meta_ventas_mensual', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('Empleados');
    }

};
