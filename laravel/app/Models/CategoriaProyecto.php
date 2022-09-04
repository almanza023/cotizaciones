<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoriaProyecto extends Model
{
    protected $table = 'categorias_proyectos';
    protected $fillable = ['id', 'proyecto_id', 'categoria_id', 'ultima_fecha',
     'ultima_entrega', 'ultimo_corte',  'estado'];

    public static function getCategoriasByProyecto($id){
        return CategoriaProyecto::where('proyecto_id', $id)->get();
    }

    public static function getUltimoRegistrado($id, $categoria){
        return CategoriaProyecto::where('proyecto_id', $id)->where('categoria_id', $categoria)
        ->where('estado', 1)
        ->latest()->first();;
    }

    public static function getId($id, $categoria){
        return CategoriaProyecto::where('proyecto_id', $id)->where('categoria_id', $categoria)
        ->where('estado', 1)->first();;
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }




}
