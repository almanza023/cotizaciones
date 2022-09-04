<?php

namespace App\Http\Livewire\Andamios;


use App\Models\Andamio;
use Livewire\Component;
use Livewire\WithPagination;

class Andamios extends Component
{
    use WithPagination;

    public $andamio_id;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=Andamio::class;
    public function render()
    {
        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.andamios.andamios', compact('data'));
    }

    public function editEstado($id)
    {
        $this->andamio_id = $id;
    }

    public function updateEstado(){
        $obj = $this->model::find($this->andamio_id);

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
