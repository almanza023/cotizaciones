<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleAndamio extends Model
{
    protected $table = 'detalles_andamios';
    protected $fillable = ['id', 'andamio_id', 'pieza_id', 'cantidad', 'peso', 'peso_total'];

    public static function getActive(){
        return DetalleAndamio::where('estado', 1)->get();
    }

    public static function getAndamio($andamio_id){
        return DetalleAndamio::where('andamio_id', $andamio_id)->get();
    }

    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }

    public function andamio()
    {
        return $this->belongsTo('App\Models\Andamio', 'andamio_id');
    }

    public static function getTotalPiezas($codigo){
        return DB::select("SELECT p.id as id, p.nombre, SUM(da.cantidad) AS total FROM detalles_andamios da INNER JOIN andamios a ON da.andamio_id=a.id
        INNER JOIN piezas p ON p.id=da.pieza_id INNER JOIN detalles_cotizaciones dco ON dco.andamio_id=a.id
        where dco.cotizacion_id=?  GROUP BY da.pieza_id order by p.nombre asc", [$codigo]);
    }

}
