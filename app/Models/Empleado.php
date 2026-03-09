<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model {

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'numero_empleado',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'puesto',
        'fecha_ingreso',
        'estatus',
        'meta_ventas_mensual'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sucursal() {
        return $this->belongsTo(Sucursal::class);
    }

}
