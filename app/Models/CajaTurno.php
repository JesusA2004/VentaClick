<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaTurno extends Model {

    protected $table = 'caja_turnos';

    protected $fillable = [
        'caja_id',
        'user_id',
        'fecha_apertura',
        'fecha_cierre',
        'monto_inicial',
        'monto_ventas_brutas',
        'monto_descuentos',
        'monto_final_calculado',
        'monto_final_declarado',
        'diferencia',
        'estado'
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime'
    ];

    public function caja() {
        return $this->belongsTo(Caja::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ventas() {
        return $this->hasMany(Venta::class);
    }

}
