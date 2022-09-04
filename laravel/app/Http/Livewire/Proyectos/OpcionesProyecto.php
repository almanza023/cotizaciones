<?php

namespace App\Http\Livewire\Proyectos;

use App\Models\Factura;
use App\Models\Proyecto;
use App\Models\Reportes\ReporteFactura;
use Livewire\Component;

class OpcionesProyecto extends Component
{
    public $proyecto_id, $data, $detalles, $fecha1, $fecha2;

    public function mount($id)
    {
        $this->proyecto_id = $id;

    }

    public function render()
    {

        $this->data=Proyecto::find($this->proyecto_id);
        return view('livewire.proyectos.opciones-proyecto');
    }

    public function consultar($id){
        $validated = $this->validate([
            'fecha1' => 'required|date',
            'fecha2' => 'required|date'

        ]);
        $this->detalles=Factura::getFechas($id, $this->fecha1, $this->fecha2);
    }
}
