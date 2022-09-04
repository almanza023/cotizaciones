<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServicioProyecto extends Model
{
    protected $table = 'servicios_proyectos';
    protected $fillable = [ 'proyecto_id',  'pieza_id', 'cantidad', 'precio',
     'total', 'dias', 'fecha', 'estado'];

    public static function getActive(){
        return ServicioProyecto::where('estado', 1)->get();
    }


    public static function getEntrega($id){
        return ServicioProyecto::where('proyecto_id', $id)->where('estado', 0)->get();
    }

    public static function getProyecto($id){
        return ServicioProyecto::where('proyecto_id', $id)->get();
    }


    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto', 'proyecto_id');
    }


}
