<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $fillable = ['id', 'nombre', 'nit', 'telefono',
     'correo', 'representante', 'direccion', 'porcentaje_iva',  'estado'];

    public static function getEmpresa(){
        return Empresa::find(1);
    }

    public static function getPorcentaje(){
        return Empresa::find(1)->porcentaje_iva;
    }

}
