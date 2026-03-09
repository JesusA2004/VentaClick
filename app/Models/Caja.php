<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model {

    protected $fillable = [
        'sucursal_id',
        'nombre',
        'clave',
        'activo'
    ];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class);
    }

    public function turnos() {
        return $this->hasMany(CajaTurno::class);
    }

    public function ventas() {
        return $this->hasMany(Venta::class);
    }

}
