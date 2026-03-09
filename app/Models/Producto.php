<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {

    protected $fillable = [
        'categoria_id',
        'codigo_barras',
        'codigo_qr',
        'sku',
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'impuesto_porcentaje',
        'permite_descuento',
        'stock_minimo',
        'unidad_medida',
        'activo'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function stocks() {
        return $this->hasMany(ProductoStock::class);
    }

    public function ventas() {
        return $this->hasMany(VentaDetalle::class);
    }

}
