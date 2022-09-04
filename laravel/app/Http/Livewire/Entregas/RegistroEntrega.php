<?php
namespace App\Http\Livewire\Entregas;

use App\Models\CategoriaCotizacion;
use App\Models\CategoriaProyecto;
use App\Models\Consecutivo;
use App\Models\ConsecutivoProyecto;
use App\Models\Cotizacion;
use App\Models\DetalleAndamio;
use App\Models\DetalleCotizacion;
use App\Models\DetalleEntrega;
use App\Models\Entrega;
use App\Models\EntregaProyecto;
use App\Models\Pieza;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistroEntrega extends Component
{

    public $proyecto, $proyecto_id, $numero, $cotizacion_id, $listadoPiezas = [], $listadoMaterial, $listadoProductos;
    public $entrega_id, $contacto, $fecha, $descripcion, $total, $obj;
    public $cantidad1 = [], $cantidad2 = [], $cantidad3 = [];
    public function mount($id)
    {
        $this->cotizacion_id = $id;
        $this->obj = Cotizacion::find($this->cotizacion_id);
        if (empty($this
            ->obj
            ->fecha_aprobacion))
        {
            session()
                ->flash('advertencia', 'LA COTIZACION NO SE ENCUENTRA APROBADA');
            return redirect()
                ->route('cotizaciones.listado');
        }
        $cot = Entrega::getByCotizacion($this->cotizacion_id);
        if (!empty($this->obj))
        {
            $this->proyecto = $this
                ->obj->proyecto;
        }

        if (!empty($cot))
        {
            if ($cot->estado == 1 || $cot->estado == 2)
            {
                //session()->flash('message', 'LA COTIZACION YA SE ENCUENTRA CERRADA');
                //return redirect()->route('cotizaciones');

            }
        }
        else
        {
            //session()->flash('message', 'NO EXISTE CODIGO');
            //return redirect()->route('cotizaciones');

        }
    }

    public function render()
    {

        $this->numero = 1;
        $this->contacto=$this->obj->contacto;
        $this->total = 0;
        $this->listadoPiezas = DetalleAndamio::getTotalPiezas($this->cotizacion_id, 1);
        $this->listadoMaterial = DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, 3);
        $this->listadoProductos = DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, 4);

        if (count($this->cantidad1) == 0)
        {
            foreach ($this->listadoPiezas as $item)
            {
                $dispo = Pieza::find($item->id);
                array_push($this->cantidad1, ["id" => $item->id, "can" => $item->total, "disponible" => $dispo->cantidad]);
            }
        }

        foreach ($this->cantidad1 as $item)
        {
            if (!empty($item['can']))
            {
                $this->total += $item['can'];
            }
        }

        if (count($this->cantidad2) == 0)
        {
            foreach ($this->listadoMaterial as $item)
            {
                array_push($this->cantidad2, ["id" => $item->pieza_id, "can" => $item->cantidad, ]);
            }
        }

        if (count($this->cantidad3) == 0)
        {
            foreach ($this->listadoProductos as $item)
            {
                array_push($this->cantidad3, ["id" => $item->pieza_id, "can" => $item->cantidad, ]);
            }
        }

        return view('livewire.entregas.registro-entrega');
    }

    public function store()
    {

        $validated = $this->validate(['contacto' => 'required', 'fecha' => 'required|date']);

        if ($this->fecha < $this
            ->obj
            ->fecha_aprobacion)
        {
            return session()
                ->flash('advertencia', 'LA FECHA DE ENTREGA DEBE SER MAYOR A LA FECHA DE APROBACIÓN');
        }

        DB::beginTransaction();
        try
        {
            $cons = Consecutivo::getActive();
            $cod = $cons->entregas + 1;
            $cons->entregas = $cod;
            $cons->save();
            //Convertir la cotizacion en proyecto

            $pro = Proyecto::create(
                ['cotizacion_id' => ($this->cotizacion_id) ,
                 'usuario_id' => (auth()->user()->id) ,
                  'nombre' => ($this->proyecto) ,
                  'fecha' => ($this->fecha)]);
            $this->proyecto_id = $pro->id;

            $categorias=DetalleCotizacion::getCategorias($this->cotizacion_id);
            foreach ($categorias as $item) {
                 CategoriaProyecto::create([
                     'proyecto_id'=>$this->proyecto_id,
                     'categoria_id'=>$item->categoria_id,
                     'ultima_fecha'=>$this->fecha,
                     'ultima_entrega'=>$this->numero,
                 ]);
            }

            //Agregar consecutivo al proyecto
            $const = ConsecutivoProyecto::create(['proyecto_id' => $this->proyecto_id, 'numero' => $this->numero, ]);
            //Generar primera entrega (Detalles)
            $obj = Entrega::create(['cotizacion_id' => ($this->cotizacion_id) , 'proyecto_id' => ($this->proyecto_id) , 'numero' => ($this->numero) , 'codigo' => ($cons->entregas) , 'contacto' => ($this->contacto) , 'descripcion' => ($this->descripcion) , 'fecha' => ($this->fecha) , 'piezas' => ($this->total) , 'usuario_id' => (auth()
                ->user()
                ->id) ]);
            if ($obj)
            {
                if (count($this->cantidad1) > 0)
                {
                    foreach ($this->cantidad1 as $item)
                    {
                        $det = DetalleEntrega::updateOrCreate(['entrega_id' => ($obj->id) , 'pieza_id' => ($item["id"]) , ], ['entrega_id' => ($obj->id) , 'pieza_id' => ($item["id"]) , 'cantidad' => ($item["can"]) ]);
                        $entrega = EntregaProyecto::registar($this->proyecto_id, $item["id"], 1, 'ANDAMIOS', $item["can"], $this->fecha);
                        Pieza::decrementar($item["id"], $item["can"], $this->fecha);
                    }
                }

                if (count($this->cantidad2) > 0)
                {
                    foreach ($this->cantidad2 as $item)
                    {
                        $det = DetalleEntrega::updateOrCreate(['entrega_id' => ($obj->id) , 'pieza_id' => ($item["id"]) , ], ['entrega_id' => ($obj->id) , 'pieza_id' => ($item["id"]) , 'cantidad' => ($item["can"]) ]);
                        $entrega = EntregaProyecto::registar($this->proyecto_id, $item["id"], 1, 'MATERIAL ENCOFRADO', $item["can"], $this->fecha);
                        Pieza::decrementar($item["id"], $item["can"], $this->fecha);

                    }
                }

                if (count($this->cantidad3) > 0)
                {
                    foreach ($this->cantidad3 as $item)
                    {
                        $det = DetalleEntrega::updateOrCreate(['entrega_id' => ($obj->id) , 'pieza_id' => ($item['id']) , ], ['entrega_id' => ($obj->id) , 'pieza_id' => ($item['id']) , 'cantidad' => ($item['can']) ]);
                        $entrega = EntregaProyecto::registar($this->proyecto_id, $item["id"], 1, 'PRODUCTOS', $item["can"], $this->fecha);
                        Pieza::decrementar($item["id"], $item["can"], $this->fecha);
                    }

                }
                $cot = Cotizacion::find($this->cotizacion_id);
                $cot->estado = 4;
                $cot->save();
                DB::commit();
                session()
                    ->flash('message', 'ENTREGA REGISTRADA EXITOSAMENTE');
                    sleep(2);
                return redirect()
                    ->route('proyectos');
                    sleep(1);

            }


        }
        catch(\Exception $e)
            {
                DB::rollback();
                session()->flash('message', $e->getMessage());
            }

    }

}

