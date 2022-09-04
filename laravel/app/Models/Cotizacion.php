<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';
    protected $fillable = ['id', 'cliente_id', 'usuario_id', 'numero', 'proyecto', 'tipo', 'contacto', 'entrega',
    'telefono', 'correo', 'forma_pago', 'fecha', 'vencimiento', 'fecha_aprobacion', 'subtotal', 'subtotal2', 'iva',
    'valor_kg', 'total', 'copiado', 'dias', 'porcentaje', 'peso', 'observaciones', 'estado'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('nombre', 'like', '%'.$search.'%')
                ->orWhere('descripcion', 'like', '%'.$search.'%');

    }

    public function setProyectoAttribute($value)
    {
        $this->attributes['proyecto'] =strtoupper($value);
    }

    public function setContactoAttribute($value)
    {
        $this->attributes['contacto'] =strtoupper($value);
    }


    public static function getActive(){
        return Cotizacion::where('estado', 1)->get();
    }

    public static function getTotalPeso($id){
        return Cotizacion::where('cotizacion_id', $id)->where('estado', 1)->sum();
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id');
    }


}
