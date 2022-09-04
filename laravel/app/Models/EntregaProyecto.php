<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EntregaProyecto extends Model
{
    protected $table = 'entregas_proyectos';
    protected $fillable = [ 'proyecto_id',  'pieza_id', 'categoria_id', 'entregadas', 'devueltas',
     'numero', 'restante', 'tipo', 'fecha', 'estado'];

    public static function getActive(){
        return EntregaProyecto::where('estado', 1)->get();
    }

    public static function getProyecto($id, $categoria){
        return EntregaProyecto::
        where('proyecto_id', $id)
        ->where('categoria_id', $categoria)
        ->where('estado', 1)->get();
    }


    public function pieza()
    {
        return $this->belongsTo('App\Models\Pieza', 'pieza_id');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto', 'proyecto_id');
    }

    public static function eliminar($pieza, $proyecto, $numero){
        $ent=EntregaProyecto::where('pieza_id', $pieza)->where('proyecto_id', $proyecto)->where('numero', $numero)->first();
       return $ent;
    }

    public static function registar($proyecto_id, $pieza_id, $numero, $tipo,  $cantidad, $fecha){

        $pieza=Pieza::find($pieza_id);
        $entrega=EntregaProyecto::where('proyecto_id', $proyecto_id)
        ->where('pieza_id', $pieza_id)
        ->where('estado', 1)
        ->first();
        if(empty($entrega)){
            EntregaProyecto::create(
                [
                    'proyecto_id' =>  ($proyecto_id),
                    'pieza_id' =>  ($pieza_id),
                    'categoria_id' =>  ($pieza->categoria_id),
                    'numero' =>  ($numero),
                    'tipo' =>  ($tipo),
                    'entregadas' => ($cantidad),
                    'restante' => ($cantidad),
                    'fecha'=>$fecha
                ]);
        }else{
            $entrega->categoria_id=$pieza->categoria_id;
            $entrega->fecha=$fecha;
            $total= $entrega->entregadas + $cantidad;
            $entrega->entregadas = $total;
            $entrega->restante = $total;
            $entrega->save();
        }

    }

    public static function registrarEntrega($data, $fecha, $numero){
        $pieza=Pieza::find($data->pieza_id);
        $entrega=EntregaProyecto::create([
                'proyecto_id' =>  ($data->proyecto_id),
                'pieza_id' =>  ($data->pieza_id),
                'categoria_id' =>  ($pieza->categoria_id),
                'numero' =>  ($numero),
                'entregadas' => ($data->entregadas),
                'restante' => ($data->restante),
                'fecha'=>$fecha
            ]);
    }

    public static function getEntregasFechas($id, $fecha1, $fecha2, $categoria, $estado){
        return EntregaProyecto::where('proyecto_id', $id)
        ->where('categoria_id', $categoria)
        ->whereBetween('fecha', [$fecha1, $fecha2])
        ->where('estado', $estado)->get();
    }










}
