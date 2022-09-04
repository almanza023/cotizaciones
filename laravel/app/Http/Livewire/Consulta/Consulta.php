<?php

namespace App\Http\Livewire\Consulta;

use App\Models\Focalizacion;
use App\Models\Fuente;
use App\Models\Municipio;
use App\Models\Tipo;
use Livewire\Component;

class Consulta extends Component
{
    public $tipo, $fuente, $municipio, $municipios, $tipos, $fuentes, $data;

    public function render()
    {
        $this->tipos=Tipo::getActive();
        $this->fuentes=Fuente::getActive();
        $this->municipios=Municipio::getActive();
        return view('livewire.consulta.consulta');
    }

    public function buscar(){

        $this->data=Focalizacion::getFiltros($this->municipio, $this->tipo, $this->fuente);

    }

}
