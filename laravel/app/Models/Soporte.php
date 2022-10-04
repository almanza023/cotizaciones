<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Soporte extends Model
{
    protected $table = 'soportes';
    protected $fillable = ['id',  'proyecto_id', 'nombre','ruta','descripcion',
    'fecha', 'archivo_base',   'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%');

    }


    public static function getActive(){
        return Soporte::where('estado', 1)->get();
    }


    public function detalles()
    {
        return $this->hasMany('App\Models\DetalleEntrega', 'entrega_id', 'id');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto', 'proyecto_id');
    }











}
