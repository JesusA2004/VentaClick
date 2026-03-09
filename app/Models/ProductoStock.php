<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoStock extends Model {

    protected $table = 'producto_stocks';

    protected $fillable = [
        'producto_id',
        'sucursal_id',
        'stock_actual',
        'stock_reservado'
    ];

    public function producto() {
        return $this->belongsTo(Producto::class);
    }

    public function sucursal() {
        return $this->belongsTo(Sucursal::class);
    }

}
