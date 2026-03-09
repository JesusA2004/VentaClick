<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('Autorizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_solicitante_id')
                ->constrained('Users')
                ->cascadeOnDelete();
            $table->foreignId('user_autorizador_id')
                ->constrained('Users')
                ->cascadeOnDelete();
            $table->string('accion', 80)->nullable();
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->string('motivo', 255)->nullable();
            $table->timestamps();
            $table->index(['referencia_tipo', 'referencia_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('Autorizacions');
    }

};
