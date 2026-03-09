<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracionSeeder extends Seeder {

    public function run(): void {
        DB::table('Configuracions')->upsert([
            [
                'clave' => 'permitir_devoluciones',
                'valor' => '1',
                'descripcion' => 'Permite procesar devoluciones en el POS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'clave' => 'permitir_descuentos',
                'valor' => '1',
                'descripcion' => 'Permite aplicar descuentos en ventas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'clave' => 'requerir_autorizacion_descuento',
                'valor' => '0',
                'descripcion' => 'Define si un descuento requiere autorización por NIP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['clave'], ['valor', 'descripcion', 'updated_at']);
    }

}
