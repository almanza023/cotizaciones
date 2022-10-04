<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reposicion extends Model
{
    protected $table = 'reposiciones';
    protected $fillable = ['id', 'pieza_id', 'proyecto_id', 'fecha',
     'categoria_id', 'fecha', 'valor', 'subtotal', 'cantidad',  'estado'];



}
