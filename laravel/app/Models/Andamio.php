<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Andamio extends Model
{
    protected $table = 'andamios';
    protected $fillable = ['id', 'codigo', 'nombre','descripcion','longitud',
    'piezas', 'peso', 'dias', 'kgdias', 'valor', 'cantidad',  'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%');

    }

    public static function getActive(){
        return Andamio::where('estado', 1)->get();
    }

    public static function getByCodigo($codigo){
        return Andamio::where('codigo', $codigo)->where('estado', 1)->first();
    }

    public function detalles()
    {
        return $this->belongsTo('App\Models\DetalleAndamio', 'andamio_id');
    }


    public function piezas()
    {
        return $this->belongsToMany('App\Models\DetalleAndamio', 'id', 'andamio_id');
    }






}
