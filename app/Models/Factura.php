<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model {

    protected $fillable = [
        'venta_id',
        'user_id',
        'cliente_id',
        'serie',
        'folio',
        'uuid',
        'estado_timbrado',
        'rfc_receptor',
        'nombre_receptor',
        'regimen_fiscal_receptor',
        'codigo_postal_receptor',
        'uso_cfdi',
        'forma_pago',
        'metodo_pago',
        'subtotal',
        'descuento',
        'impuestos',
        'total',
        'xml_timbrado',
        'pdf_url',
        'fecha_timbrado'
    ];

    protected $casts = [
        'fecha_timbrado' => 'datetime'
    ];

    public function venta() {
        return $this->belongsTo(Venta::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

}
