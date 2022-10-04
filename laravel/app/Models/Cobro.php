<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table = 'cobros';
    protected $fillable = ['id', 'proyecto_id', 'usuario_id', 'categoria_id',
     'fecha_corte', 'fecha1', 'fecha2', 'subtotal_reposicion',
     'piezas',  'dias', 'pesototal', 'pesodiatotal', 'cantidadtotal', 'subtotal', 'iva', 'total',
      'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%');

    }
    public static function getProyecto($proyecto_id, $categoria_id){
        if($categoria_id==0){
            return Cobro::where('proyecto_id', $proyecto_id)->where('estado', 1)
            ->orderBy('fecha1', 'asc')
            ->get();
        }else{
            return Cobro::where('proyecto_id', $proyecto_id)
            ->where('categoria_id', $categoria_id)
            ->where('estado', 1)
            ->orderBy('fecha1', 'asc')
            ->get();
        }

    }


    public static function getActive(){
        return Cobro::where('estado', 1)->get();
    }

    public static function ultimoCobro($id){
        return Cobro::where('proyecto_id', $id)->latest()->first();
    }

    public static function getfechas($id, $fecha1, $fecha2){
        return Cobro::where('proyecto_id', $id)
        ->whereBetween('fecha2', [$fecha1, $fecha2])
       ->get();
    }
    public static function getFechasByEstado($id, $categoria_id, $fecha1, $fecha2, $estado){
        return Cobro::where('proyecto_id', $id)
        ->where('categoria_id', $categoria_id)
        ->whereBetween('fecha2', [$fecha1, $fecha2])
        ->where('estado', $estado)
        ->get();
    }

    public static function getFactura($id){
        return Cobro::where('factura_id', $id)->get();
    }

    public static function getTotalSubtotal($proyecto_id){
        $sum = Cobro::where('proyecto_id', $proyecto_id)->where('estado', 1)->sum('subtotal');
        if(empty($sum)){
            return 0;
        }
        return $sum;
    }

    public static function getTotalIva($proyecto_id){
        $sum = Cobro::where('proyecto_id', $proyecto_id)->where('estado', 1)->sum('iva');
        if(empty($sum)){
            return 0;
        }
        return $sum;
    }

    public static function getTotalTotal($proyecto_id){
        $sum = Cobro::where('proyecto_id', $proyecto_id)->where('estado', 1)->sum('total');
        if(empty($sum)){
            return 0;
        }
        return $sum;
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
