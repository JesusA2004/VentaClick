<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model {

    protected $table = 'descuentos';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'valor',
        'fecha_inicio',
        'fecha_fin',
        'limite_usos',
        'usos_actuales',
        'activo'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'activo' => 'boolean',
        'valor' => 'decimal:2'
    ];

    public function ventas() {
        return $this->hasMany(Venta::class);
    }

    public function estaActivo() {
        if (!$this->activo) {
            return false;
        }
        if ($this->fecha_inicio && now()->lt($this->fecha_inicio)) {
            return false;
        }
        if ($this->fecha_fin && now()->gt($this->fecha_fin)) {
            return false;
        }
        if ($this->limite_usos && $this->usos_actuales >= $this->limite_usos) {
            return false;
        }
        return true;
    }

    public function calcularDescuento($subtotal) {
        if ($this->tipo === 'PORCENTAJE') {
            return ($subtotal * $this->valor) / 100;
        }
        return $this->valor;
    }

}
