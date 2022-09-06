<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Andamio extends Model
{
    protected $table = 'andamios';
    protected $fillable = ['id', 'codigo', 'nombre','descripcion','longitud', 'categoria_id',
    'piezas', 'peso', 'dias', 'kgdias', 'valor', 'cantidad',  'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%')->get();

    }
    public static function searchActivos($search, $categoria)
    {
        if(empty($categoria)){
            return empty($search)  ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%');
        }else{
            return (empty($search)) ? static::query()->where('categoria_id', $categoria)
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->where('categoria_id', $categoria);
        }
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
