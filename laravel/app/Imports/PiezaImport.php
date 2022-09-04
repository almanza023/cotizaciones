<?php

namespace App\Imports;

use App\Models\Pieza;
use Maatwebsite\Excel\Concerns\ToModel;

class PiezaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pieza([
            'categoria_id' =>$row['categoria'],
            'nombre' =>$row['nombre'],
            'descripcion'=>$row['descripcion'],
            'referencia'=>$row['referencia'],
            'cantidad'=>$row['cantidad'],
            'peso'=>$row['peso'],
            'peso_total'=>$row['cantidad'] * $row['peso'],
            'precio' =>$row['precio']
        ]);
    }
}
