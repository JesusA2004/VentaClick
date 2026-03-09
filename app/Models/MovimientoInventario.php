<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model {

    protected $table = 'movimientos_inventarios';

    protected $fillable = [
        'producto_id',
        'sucursal_id',
        'user_id',
        'tipo',
        'cantidad',
        'referencia_tipo',
        'referencia_id'
    ];

    public function producto() {
        return $this->belongsTo(Producto::class);
    }

    public function sucursal() {
        return $this->belongsTo(Sucursal::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
