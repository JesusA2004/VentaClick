<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'rfc',
        'nombre_fiscal',
        'regimen_fiscal',
        'codigo_postal_fiscal',
        'uso_cfdi_default',
        'direccion',
        'activo'
    ];

    public function ventas() {
        return $this->hasMany(Venta::class);
    }

    public function facturas() {
        return $this->hasMany(Factura::class);
    }

}
