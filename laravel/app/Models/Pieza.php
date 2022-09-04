<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    protected $table = 'piezas';
    protected $fillable = ['categoria_id','nombre','descripcion', 'referencia', 'cantidad', 'peso',
    'peso_total', 'precio', 'estado' ];

    public static function search($search, $categoria)
    {

        if(empty($categoria)){
            return empty($search)  ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('referencia', 'like', '%'.$search.'%');
        }else{
            return (empty($search)) ? static::query()->where('categoria_id', $categoria)
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('referencia', 'like', '%'.$search.'%')
                ->where('categoria_id', $categoria);
        }
    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper($value);
    }

    public static function getActive(){
        return Pieza::where('estado', 1)->get();
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }

    public static function decrementar($id, $cantidad, $fecha){
        $pieza=Pieza::find($id);
        if($pieza->cantidad > 0){
            $pieza->cantidad= $pieza->cantidad-$cantidad;
        }
        $pieza->save();
        $movimiento=Movimiento::create([
            'pieza_id'=>$id,
            'cantidad'=>$cantidad,
            'tipo'=>'SALIDA',
            'fecha_salida'=>$fecha
        ]);
    }

    public static function incrementar($id, $cantidad, $fecha){
        $pieza=Pieza::find($id);
        if($pieza->cantidad > 0){
            $pieza->cantidad=$pieza->cantidad + $cantidad;
        }
        $pieza->save();
        $movimiento=Movimiento::create([
            'pieza_id'=>$id,
            'cantidad'=>$cantidad,
            'tipo'=>'ENTRADA',
            'fecha_entrada'=>$fecha
        ]);
    }








}
