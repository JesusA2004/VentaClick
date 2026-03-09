<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaPago extends Model {

    protected $table = 'venta_pagos';

    protected $fillable = [
        'venta_id',
        'metodo_pago',
        'monto',
        'referencia'
    ];

    public function venta() {
        return $this->belongsTo(Venta::class);
    }

}
