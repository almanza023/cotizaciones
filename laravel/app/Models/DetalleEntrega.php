<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleEntrega extends Model
{
    protected $table = 'detalles_entregas';
    protected $fillable = ['id', 'entrega_id', 'pieza_id', 'cantidad', 'devueltas',
     'dias', 'restante', 'fecha_entrega', 'fecha_devolucion', 'estado'];

    public static function getActive(){
        return DetalleEntrega::where('estado', 1)->get();
    }

    public static function getEntrega($id){
        return DetalleEntrega::where('entrega_id', $id)->get();
    }

    public static function getEntregaPieza($pieza){
        return DetalleEntrega::where('pieza_id', $pieza)
        ->latest()->first();
    }



    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }

    public function entrega()
    {
        return $this->belongsTo('App\Models\Entrega', 'entrega_id');
    }









}
