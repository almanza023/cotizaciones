<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CobroEncofrado extends Model
{
    protected $table = 'cobros_encofrados';

    protected $fillable = [
    'id', 'proyecto_id', 'usuario_id', 'fecha_corte', 'fecha1', 'fecha2',
     'subtotal',  'dias', 'iva', 'total',  'estado'
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%');
    }

    public static function getProyecto($proyecto_id){
        return CobroEncofrado::where('proyecto_id', $proyecto_id)->where('estado', 1)
        ->orderBy('fecha1', 'asc')
        ->get();
    }


    public static function getActive(){
        return CobroEncofrado::where('estado', 1)->get();
    }

    public static function ultimoCobro($id){
        return CobroEncofrado::where('proyecto_id', $id)->latest()->first();
    }

    public static function getfechas($id, $fecha1, $fecha2){
        return CobroEncofrado::where('proyecto_id', $id)
        ->whereBetween('fecha2', [$fecha1, $fecha2])
       ->get();
    }
    public static function getFechasByEstado($id, $fecha1, $fecha2, $estado){
        return CobroEncofrado::where('proyecto_id', $id)
        ->whereBetween('fecha2', [$fecha1, $fecha2])
        ->where('estado', $estado)
        ->get();
    }

    public static function getFactura($id){
        return CobroEncofrado::where('factura_id', $id)->get();
    }


    public function factura()
    {
        return $this->belongsTo('App\Models\Factura', 'factura_id');
    }

   public function detalles()
   {
       return $this->hasMany('App\Models\Subcobro', 'cobro_id', 'id');
   }










}
