<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model {

    protected $table = 'sucursals';

    protected $fillable = [
        'nombre',
        'clave',
        'telefono',
        'email',
        'direccion',
        'activo'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function empleados() {
        return $this->hasMany(Empleado::class);
    }

    public function cajas() {
        return $this->hasMany(Caja::class);
    }

    public function ventas() {
        return $this->hasMany(Venta::class);
    }

    public function productosStock() {
        return $this->hasMany(ProductoStock::class);
    }

}
