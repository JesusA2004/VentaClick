<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model {

    protected $fillable = [
        'sucursal_id',
        'caja_id',
        'caja_turno_id',
        'user_id',
        'cliente_id',
        'descuento_id',
        'subtotal',
        'descuento_total',
        'impuesto_total',
        'total',
        'total_pagado',
        'cambio',
        'estado'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function caja() {
        return $this->belongsTo(Caja::class);
    }

    public function turno() {
        return $this->belongsTo(CajaTurno::class,'caja_turno_id');
    }

    public function detalles() {
        return $this->hasMany(VentaDetalle::class);
    }

    public function pagos() {
        return $this->hasMany(VentaPago::class);
    }

    public function factura() {
        return $this->hasOne(Factura::class);
    }

}
