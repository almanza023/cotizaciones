<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsecutivoProyecto extends Model
{
    protected $table = 'consecutivos_proyectos';
    protected $fillable = ['id', 'proyecto_id', 'numero', 'subcobros', 'estado'];

    public static function getProyectoId($proyecto){
        return ConsecutivoProyecto::where('proyecto_id', $proyecto)->first();
    }

    public static function getProyecto($proyecto){
        $cont=ConsecutivoProyecto::where('proyecto_id', $proyecto)->first();
        $numero=0;
        if(!empty($cont)){
            $numero=$cont->numero;
        }
        return $numero;
    }

    public static function getSubcobros($proyecto){
        $cont=ConsecutivoProyecto::where('proyecto_id', $proyecto)->first();
        $numero=0;
        if(!empty($cont)){
            $numero=$cont->subcobro;
        }
        return $numero;
    }

    public static function aumentar($id){
        $conse=DB::table('consecutivos_proyectos')->where('proyecto_id', $id)->increment('votes');
        return $conse;
    }
}
