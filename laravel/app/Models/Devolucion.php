<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Devolucion extends Model
{
    protected $table = 'devoluciones';
    protected $fillable = ['id', 'proyecto_id', 'pieza_id', 'categoria_id', 'cantidad','fecha',   'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('contacto', 'like', '%'.$search.'%');

    }

    public static function getActive(){
        return Devolucion::where('estado', 1)->get();
    }

    public static function getproyecto($proyecto_id){
        return Devolucion::where('proyecto_id', $proyecto_id)
        ->orderBy('fecha', 'desc')
        ->get();
    }

    public static function getProyectoCategoria($proyecto_id, $categoria_id){
        return Devolucion::where('proyecto_id', $proyecto_id)
        ->where('categoria_id', $categoria_id)
        ->orderBy('fecha', 'desc')
        ->get();
    }

    public static function getPieza($proyecto, $pieza, $fecha1, $fecha2){
        return Devolucion::where('proyecto_id', $proyecto)->where('pieza_id', $pieza)
        ->where('estado',1)
        ->whereBetween('fecha', [$fecha1, $fecha2])
        ->first();
    }

    public static function getProyectoFecha($proyecto, $fecha1, $fecha2){
        return Devolucion::where('proyecto_id', $proyecto)
        ->where('estado',1)
        ->whereBetween('fecha', [$fecha1, $fecha2])
        ->get();
    }

    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }











}
