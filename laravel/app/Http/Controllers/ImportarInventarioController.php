<?php

namespace App\Http\Controllers;

use App\Imports\PiezaImport;
use App\Models\Categoria;
use App\Models\Huella;
use App\Models\Movimiento;
use App\Models\Pieza;
use App\Models\ProfesionalUnidad;
use App\Models\Unidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ImportarInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias=Categoria::getActive();
        return view('piezas.importar', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importar()
    {

        $collection = Excel::toArray(new PiezaImport, request()->file('file'));

        $i=1;
        $date = Carbon::now()->format('Y-m-d');
        $categoria=request()->input('categoria_id');

        for ($i=1; $i <count($collection[0]) ; $i++) {
            $nombre= $collection[0][$i][1];
            $descripcion= $collection[0][$i][2];
            $referencia= $collection[0][$i][3];
            $cantidad= $collection[0][$i][4];
            $peso= $collection[0][$i][5];
            $precio= $collection[0][$i][6];

            $pieza=Pieza::create([
                'categoria_id'=>$categoria,
                'nombre'=>$nombre,
                'descripcion'=>$descripcion,
                'referencia'=>$referencia,
                'cantidad'=>$cantidad,
                'peso'=>$peso,
                'precio'=>$precio,
            ]);

            if($pieza){
                Movimiento::create([
                    'pieza_id'=>$pieza->id,
                    'cantidad'=>$cantidad,
                    'peso'=>$peso,
                    'precio'=>$precio,
                    'tipo'=>'ENTRADA',
                    'fecha_entrada'=>$date
                ]);
            }
            $i++;
        }

        return redirect()->back()->with('message', 'DATOS REGISTRADOS EXITOSAMENTE');

    }









}
