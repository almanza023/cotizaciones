<?php

namespace App\Http\Livewire\Devoluciones;

use App\Models\DetalleEntrega;
use App\Models\Devolucion;
use App\Models\Entrega;

use Livewire\Component;

class VerDevolucion extends Component
{

    public $proyecto_id;
    public $data;
    public function mount($id)
    {
        $this->proyecto_id = $id;
    }

    public function render()
    {
        $this->data=Devolucion::getProyecto($this->proyecto_id);

        return view('livewire.devoluciones.ver-devolucion');
    }




}
