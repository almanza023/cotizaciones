<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\CategoriaProyecto;
use App\Models\Cotizacion;
use App\Models\DetalleAndamio;
use App\Models\DetalleCotizacion;
use App\Models\Movimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VerCotizacion extends Component
{

    public $cotizacion_id;
    public $listadoAndamios, $listadoMaterial, $listadoProductos, $listadoServicios, $data, $fecha;
    public $total_cot, $observaciones;
    public function mount($id)
    {
        $this->cotizacion_id = $id;
    }

    public function render()
    {
        $this->data=Cotizacion::find($this->cotizacion_id);
        //Aprobado
        if($this->data->estado==2){
            $this->fecha=$this->data->fecha_aprobacion;
        }
        if(!empty($this->data)){
            $this->listadoAndamios=DetalleCotizacion::getAndamios($this->cotizacion_id, 1);
            $this->listadoMaterial=DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, 3);
            $this->listadoProductos=DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, 4);
            $this->listadoServicios=DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, 5);
        }
        return view('livewire.cotizaciones.ver-cotizacion');
    }

    public function aprobar(){
        $categorias=DetalleCotizacion::getCategorias($this->cotizacion_id);
        $validated = $this->validate([
            'fecha' => 'required|date'
        ]);
        $date=$this->fecha;
        //Verificar que fecha de entrega sea mayor a la fecha de la cotización
        if($date<$this->data->fecha){
            return session()->flash('advertencia', 'FECHA DE APROBACION DEBE SER MAYOR A ', $this->data->fecha);
        }
        $this->data->estado=2;
        $this->data->fecha_aprobacion=$date;
        $this->data->observaciones=$this->observaciones;
        $this->data->save();
        session()->flash('message', 'COTIZACIÓN APROBADA EXITOSAMENTE');
    }

    public function rechazar(){
        $this->data->estado=3;
        $this->data->observaciones=$this->observaciones;
        $this->data->save();
        session()->flash('advertencia', 'COTIZACIÓN RECHAZADA');

    }
}
