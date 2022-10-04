<?php

namespace App\Http\Livewire\Liquidaciones;


use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\Entrega;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Liquidaciones extends Component
{
    use WithPagination;

    public $entrega_id;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=Entrega::class;
    public function render()
    {
        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.entregas.entregas', compact('data'));
    }

    public function editEstado($id)
    {
        $this->cotizacion_id = $id;
    }

    public function updateEstado(){
        $obj = $this->model::find($this->cotizacion_id);

        if($obj->estado==1){
            $obj->estado=0;
            $obj->save();
        }else{
            $obj->estado=1;
            $obj->save();
        }
        session()->flash('message', 'ESTADO ACTUALIZADO EXITOSAMENTE');
        $this->emit('closeModalEstado');


    }








}
