<?php

namespace App\Http\Livewire\Proyectos;

use App\Models\CategoriaProyecto;
use App\Models\Cobro;
use App\Models\Subcobro;
use Livewire\Component;

class VerCobros extends Component
{
    public $proyecto_id, $categoria_id, $data=[], $detalles=[];

    public function mount($id)
    {
        $this->proyecto_id = $id;
    }


    public function render()
    {
        $this->categorias=CategoriaProyecto::getCategoriasByProyecto($this->proyecto_id);
        return view('livewire.proyectos.ver-cobros');
    }

    public function ver($id){
        $this->detalles=Subcobro::getDetalles($id);

    }

    public function consultar(){

        $this->data=Cobro::getProyecto($this->proyecto_id, $this->categoria_id);
    }




}
