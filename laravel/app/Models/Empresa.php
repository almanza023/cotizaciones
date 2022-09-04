<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $fillable = ['id', 'nombre', 'nit', 'contrato', 'correo', 'representante', 'documento',  'estado'];

    public static function getEmpresa(){
        return Empresa::find(1);
    }

}
