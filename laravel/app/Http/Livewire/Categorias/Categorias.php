<?php

namespace App\Http\Livewire\Categorias;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class Categorias extends Component
{
    use WithPagination;
    public $nombre, $descripcion,
    $categoria_id,  $updateMode=false;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=Categoria::class;

    public function render()    {

        $data=$this->model::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        return view('livewire.categorias.categorias', compact('data'));
    }

    public function resetInputFields(){
        $this->nombre='';
        $this->descripcion='';
        $this->categoria_id='';
        $this->updateMode=false;
    }

    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
        ]);

            $cliente=$this->model::updateOrCreate(
                [
                    'id' =>  ($this->categoria_id)
                ],
                [
                    'nombre' => ($this->nombre),
                    'descripcion' =>  ($this->descripcion)
                ]);
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
            $this->resetInputFields();
            $this->emit('closeModal');

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->categoria_id = $id;
        $this->nombre = $obj->nombre;
        $this->descripcion = $obj->descripcion;

    }

    public function editEstado($id)
    {
        $this->categoria_id = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updateEstado(){
        $obj = $this->model::find($this->categoria_id);

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
