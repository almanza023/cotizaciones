<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'contactos';
    protected $fillable = ['id', 'nombre', 'numero', 'tipo_doc', 'proyecto', 'telefono', 'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('numero', 'like', '%'.$search.'%');

    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper($value);
    }

    public static function getByDocumento($numero){
        return Contacto::where('numero', $numero)->where('estado', 1)->first();
    }

    public static function getActive(){
        return Contacto::where('estado', 1)->get();
    }
}
