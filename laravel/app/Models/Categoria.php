<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['id', 'nombre', 'descripcion',  'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%');

    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper($value);
    }


    public static function getActive(){
        return Categoria::where('estado', 1)->get();
    }
}
