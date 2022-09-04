<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleCobro extends Model
{
    protected $table = 'detalles_cobros';
    protected $fillable = [ 'proyecto_id','cobro_id',  'entrega_id', 'pieza_id', 'cantidad', 'peso', 'pesodia', 'dias',  'estado'];

    public static function getActive(){
        return DetalleCobro::where('estado', 1)->get();
    }

    public static function getProyecto($id){
        return DetalleCobro::where('proyecto_id', $id)->get();
    }

    public static function getCobro($id){
        return DetalleCobro::where('cobro_id', $id)->get();
    }


    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }

    public function cobro()
    {
        return $this->belongsTo('App\Models\Cobro', 'cobro_id');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto', 'proyecto_id');
    }


}
