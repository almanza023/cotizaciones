<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $fillable = ['id', 'pieza_id', 'cantidad', 'peso', 'precio', 'tipo', 'fecha_entrada', 'fecha_salida'];

    public static function getActive(){
        return Movimiento::where('estado', 1)->get();
    }

    public static function getPiezaId($pieza_id){
        return Movimiento::where('pieza_id', $pieza_id)->get();
    }

    public static function crear($data){


    }

    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }

}
