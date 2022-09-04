<?php

namespace App\Http\Livewire\Entregas;

use App\Models\DetalleEntrega;
use App\Models\Entrega;

use Livewire\Component;

class VerEntrega extends Component
{

    public $entrega_id, $proyecto_id;
    public $data, $detalles;
    public function mount($id)
    {
        $this->entrega_id = $id;
    }

    public function render()
    {
        $this->data=Entrega::find($this->entrega_id);
        $this->proyecto_id=$this->data->proyecto_id;
        if(!empty($this->data)){
            $this->detalles=DetalleEntrega::getEntrega($this->entrega_id);
        }
        return view('livewire.entregas.ver-entrega');
    }




}
