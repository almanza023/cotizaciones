<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleCotizacion extends Model
{
    protected $table = 'detalles_cotizaciones';
    protected $fillable = ['id', 'cotizacion_id', 'andamio_id', 'pieza_id', 'categoria_id', 'cantidad', 'subtotal', 'iva', 'porcentaje',
    'total', 'dias',  'peso', 'precio', 'peso_total', 'iva', 'estado'];

    public static function getActive(){
        return DetalleCotizacion::where('estado', 1)->get();
    }

    public static function getCotizacionGeneral($id){
        return DetalleCotizacion::where('cotizacion_id', $id)->get();
    }

    public static function getCotizacion($id, $estado, $categoria){
        return DetalleCotizacion::where('cotizacion_id', $id)
        ->where('estado', $estado)->where('categoria_id', $categoria)->get();
    }

    public static function getAndamios($id, $estado){
        return DetalleCotizacion::where('cotizacion_id', $id)
        ->where('estado', $estado)->whereIn('categoria_id', ['1', '2'])->get();
    }

    public static function getTotalPeso($id){
        return DetalleCotizacion::where('cotizacion_id', $id)->where('estado', 1)->sum('peso_total');
    }

    public function andamio()
    {
        return $this->belongsTo('App\Models\Andamio', 'andamio_id');
    }

    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }

    public static function totales($cotizacion_id, $categoria){
       if($categoria<=2){
        $detalles=DB::select('SELECT SUM(a.peso) AS peso, SUM(a.piezas) AS piezas, SUM(a.kgdias) as kgdias  FROM detalles_cotizaciones dc INNER JOIN andamios a ON dc.andamio_id=a.id
        WHERE dc.cotizacion_id=? and dc.estado=0 and dc.categoria_id=?', [$cotizacion_id, $categoria]);
        return $detalles;
       }else{
        $detalles=DB::select('SELECT SUM(peso_total) AS peso, SUM(cantidad) AS piezas, SUM(subtotal) as kgdias FROM detalles_cotizaciones dc
        WHERE dc.cotizacion_id=? and dc.andamio_id is null and dc.categoria_id=?', [$cotizacion_id, $categoria]);
        return $detalles;
       }
    }

    public static function totalCotizacion($id){
        $cat1=DB::select('SELECT SUM(subtotal) AS subtotal, SUM(iva) AS iva, SUM(total) as total, SUM(peso_total) as peso FROM detalles_cotizaciones dc
        WHERE dc.cotizacion_id=? and (dc.categoria_id=1 or dc.categoria_id=2)', [$id]);
        $cat2=DB::select('SELECT SUM(subtotal) AS subtotal, SUM(iva) AS iva, SUM(total) as total, SUM(peso_total) as peso FROM detalles_cotizaciones dc
        WHERE dc.cotizacion_id=? and dc.categoria_id=3', [$id]);
        $cat3=DB::select('SELECT SUM(subtotal) AS subtotal, SUM(iva) AS iva, SUM(total) as total, SUM(peso_total) as peso FROM detalles_cotizaciones dc
        WHERE dc.cotizacion_id=? and dc.categoria_id=4', [$id]);
        $cat4=DB::select('SELECT SUM(subtotal) AS subtotal, SUM(iva) AS iva, SUM(total) as total FROM detalles_cotizaciones dc
        WHERE dc.cotizacion_id=? and dc.categoria_id=5', [$id]);
        $subtotal1=($cat1[0]->subtotal+ $cat2[0]->subtotal + $cat3[0]->subtotal );
        $subtotal2=($cat4[0]->subtotal );
        $iva=($cat1[0]->iva+ $cat2[0]->iva + $cat3[0]->iva);
        $peso=($cat1[0]->peso+ $cat2[0]->peso + $cat3[0]->peso);
        $total=$subtotal1+$subtotal2+$iva;
        return [
            'nomcat1'=>'ANDAMIOS',
            'subcat1'=>$cat1[0]->subtotal,
            'ivacat1'=>$cat1[0]->iva,
            'totcat1'=>$cat1[0]->total,
            'nomcat2'=>'MATERIAL ENCOFRADO',
            'subcat2'=>$cat2[0]->subtotal,
            'ivacat2'=>$cat2[0]->iva,
            'totcat2'=>$cat2[0]->total,
            'nomcat3'=>'PRODUCTOS',
            'subcat3'=>$cat3[0]->subtotal,
            'ivacat3'=>$cat3[0]->iva,
            'totcat3'=>$cat3[0]->total,
            'nomcat4'=>'SERVICIOS',
            'subcat4'=>$cat4[0]->subtotal,
            'ivacat4'=>$cat4[0]->iva,
            'totcat4'=>$cat4[0]->total,
            'subtotal1'=>$subtotal1,
            'subtotal2'=>$subtotal2,
            'iva'=>$iva,
            'total'=>$total,
            'peso'=>$peso,
        ];
    }

    public static function getCategorias($id){
        return DB::table('detalles_cotizaciones')
        ->select('categoria_id')
        ->where('cotizacion_id', $id)
        ->distinct()
        ->get();
    }









}
