<?php

namespace App\Http\Livewire\Entregas;

use App\Models\Categoria;
use App\Models\Consecutivo;
use App\Models\ConsecutivoProyecto;
use App\Models\Cotizacion;
use App\Models\DetalleEntrega;
use App\Models\Entrega;
use App\Models\EntregaProyecto;
use App\Models\Pieza;
use App\Models\Proyecto;
use App\Models\ServicioProyecto;
use Carbon\Carbon;
use Livewire\Component;

class EntregaServicio extends Component
{

    public $proyecto_id, $cotizacion_id,  $categoria_id=5, $categorias, $cantidad, $dias, $fecha, $nombre_proyecto;
    public $registrado=false, $detalles, $proyecto;

    public $entrega_id, $contacto, $descripcion, $total;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function mount($id)
    {
        $this->proyecto_id = $id;
    }

    public function render()
    {
        $this->cantidad='';
        $this->proyecto=Proyecto::find($this->proyecto_id);
        $this->fecha=Carbon::now()->format('Y-m-d');
        $piezas=[];
        $this->categorias=[];
        if(!empty($this->categoria_id)){
            $piezas=Pieza::search($this->search, $this->categoria_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);
        }
        return view('livewire.entregas.entrega-servicio', compact('piezas'));
    }

    public function add($id){
        $validated = $this->validate([
            'cantidad' => 'required',
            'dias'=>'required'
        ]);
        $pieza=Pieza::find($id);

        if(!empty($pieza)){
            $det=ServicioProyecto::updateOrCreate(
                [
                    'proyecto_id' =>  ($this->proyecto_id),
                    'pieza_id' =>  ($id),
                    'estado'=>0
                ],
                [
                    'proyecto_id' =>  ($this->proyecto_id),
                    'pieza_id' =>  ($id),
                    'fecha' => ($this->fecha),
                    'cantidad' => ($this->cantidad),
                    'dias' => ($this->dias),
                    'precio' => ($pieza->precio),
                    'total' => ($pieza->precio * $this->dias * $this->cantidad),
                    'estado'=>0
                ]);
            $this->detalles=ServicioProyecto::getEntrega($this->proyecto_id);
            $this->cantidad='';
            $this->dias='';
        }

    }



    public function quitar($id){
        $det=ServicioProyecto::find($id);
        $det->delete();
        $this->detalles=ServicioProyecto::getEntrega($this->entrega_id);
    }

    public function finalizar(){

        foreach ($this->detalles as $item) {
            $item->estado=1;
            $item->save();
         }
         session()->flash('message', 'DATOS AGREGADA EXITOSAMENTE');
         return redirect()->route('proyectos.opciones', $this->proyecto_id);
    }
}
