<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['cotizacion_id','usuario_id','nombre', 'fecha',
    'ultima_entrega', 'ultima_fecha', 'ultima_fecha_encofrado', 'ultimo_corte', 'ultimo_corte_encofrado',
     'estado' ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%');

    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper($value);
    }

    public static function getActive(){
        return Proyecto::where('estado', 1)->get();
    }

    public static function getByCotizacion($cotizacion_id){
        return Proyecto::where('cotizacion_id', $cotizacion_id)->where('estado', 1)->first();
    }

    public function cotizacion()
    {
        return $this->belongsTo('App\Models\Cotizacion', 'cotizacion_id');
    }








}
