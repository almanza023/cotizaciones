<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $fillable = ['id', 'proyecto_id', 'categoria_id', 'usuario_id', 'numero', 'fecha_gen', 'fecha1', 'fecha2',
     'subtotal',  'iva',   'valor_kg', 'total', 'porcentaje', 'peso',  'estado'];

    public static function getFechas($proyecto, $fecha1, $fecha2){
        return Factura::where('proyecto_id', $proyecto)
        ->whereBetween('fecha_gen', [$fecha1, $fecha2])
        ->where('estado', 1)
        ->get();

    }





}
