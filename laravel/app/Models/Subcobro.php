<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subcobro extends Model
{
    protected $table = 'subcobros';
    protected $fillable = [ 'proyecto_id', 'pieza_id', 'categoria_id', 'cobro_id', 'valor', 'subtotal', 'iva', 'total',
     'numero', 'fecha1', 'fecha2', 'cantidad', 'peso', 'pesodia', 'dias',  'estado'];



    public static function getfechas($id, $pieza, $fecha1, $fecha2){
        return Subcobro::where('proyecto_id', $id)
        ->where('pieza_id', $pieza)
        ->whereBetween('fecha2', [$fecha1, $fecha2])
       ->sum('pesodia');
    }

    public static function getDetalles($id){
        return Subcobro::where('cobro_id', $id)->get();
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
