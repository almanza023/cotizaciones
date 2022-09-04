<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Entrega extends Model
{
    protected $table = 'entregas';
    protected $fillable = ['id', 'cotizacion_id', 'categoria_id', 'usuario_id', 'proyecto_id', 'contacto','codigo','descripcion',
    'fecha', 'devoluciones', 'numero', 'piezas',   'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('contacto', 'like', '%'.$search.'%');

    }

    public static function searchProyecto($search, $proyecto)
    {
        return empty($search) ? static::query()->where('proyecto_id', $proyecto)
            : static::query()->where('proyecto_id', $proyecto)->where('id', 'like', '%'.$search.'%')
                ->orWhere('contacto', 'like', '%'.$search.'%');

    }

    public static function getActive(){
        return Entrega::where('estado', 1)->get();
    }

    public static function getByCodigo($codigo){
        return Entrega::where('codigo', $codigo)->where('estado', 1)->first();
    }

    public static function getByCotizacion($codigo){
        return Entrega::where('cotizacion_id', $codigo)->where('estado', 1)->first();
    }

    public function detalles()
    {
        return $this->hasMany('App\Models\DetalleEntrega', 'entrega_id', 'id');
    }


    public function cotizacion()
    {
        return $this->belongsTo('App\Models\Cotizacion', 'cotizacion_id');
    }

    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }


    public static function primeraEntrega($proyecto_id){
        return Entrega::where('proyecto_id', $proyecto_id)->where('numero', 1)->first();
    }

    public static function getNumeroEntrega($proyecto_id){
        return Entrega::where('proyecto_id', $proyecto_id)->latest('id')->first();;
    }

    public static function getEntregaFechas($id, $fecha1, $fecha2, $estado){
        return Entrega::where('proyecto_id', $id)
        ->whereBetween('fecha', [$fecha1, $fecha2])
        ->where('estado', $estado)->get();
    }

    public static function aumentaNumeroEntrega($proyecto_id){
         $entrega=Entrega::where('proyecto_id', $proyecto_id)->latest('numero')->first();
         $num=$entrega->numero + 1;
         return $num;
    }

    public static function getUltimaEntrega($proyecto_id){
        return Entrega::where('proyecto_id', $proyecto_id)
        ->where('estado', 1)
        ->latest()->first();
    }

    public static function getUltimaEntregabyCategoria($proyecto_id, $categoria){
        return Entrega::where('proyecto_id', $proyecto_id)->where('categoria_id', $categoria)
        ->where('estado', 1)
        ->latest()->first();;
    }










}
