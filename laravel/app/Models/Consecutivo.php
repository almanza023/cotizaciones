<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consecutivo extends Model
{
    protected $table = 'consecutivos';
    protected $fillable = ['id', 'cotizacion', 'andamios', 'entregas', 'estado'];

    public static function getActive(){
        return Consecutivo::where('estado', 1)->first();
    }

    public static function aumentarConsEntregas(){
        $cons=Consecutivo::getActive();
        $cod=$cons->entregas+1;
        $cons->entregas=$cod;
        $cons->save();
        return $cons;
    }
}
