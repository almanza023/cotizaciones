<?php

namespace App\Http\Livewire\Proyectos;

use App\Models\CategoriaProyecto;
use App\Models\EntregaProyecto;
use Livewire\Component;

class VerEntregaProyecto extends Component
{
    public $proyecto_id, $categoria_id;
    public $data, $detalles, $total=0;
    public function mount($id)
    {
        $this->proyecto_id = $id;
    }
    public function render()
    {
       $this->categorias=CategoriaProyecto::getCategoriasByProyecto($this->proyecto_id);
       if(!empty($this->categoria_id)){
        $this->detalles=EntregaProyecto::getProyecto($this->proyecto_id, $this->categoria_id);
        $this->total=EntregaProyecto::getTotalPiezas($this->proyecto_id, $this->categoria_id, 1);
       }

        return view('livewire.proyectos.ver-entrega-proyecto');
    }
}
