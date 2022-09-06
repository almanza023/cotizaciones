<?php

namespace App\Http\Livewire\Piezas;

use App\Models\Categoria;
use App\Models\Pieza;
use Livewire\Component;
use Livewire\WithPagination;

class Piezas extends Component
{
    use WithPagination;
    public $nombre, $categoria_id, $descripcion, $referencia, $cantidad, $peso, $peso_total,
    $pieza_id,  $updateMode=false, $categorias=[], $categoria, $precio=0;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=Pieza::class;

    public function render()    {

        $data=$this->model::search($this->search,  $this->categoria)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        $this->categorias=Categoria::getActive();
        if(!empty($this->cantidad) && !empty($this->peso)){
            $this->peso_total=$this->peso * $this->cantidad;
        }
        return view('livewire.piezas.piezas', compact('data'));
    }

    public function resetInputFields(){
        $this->nombre='';
        $this->categoria_id='';
        $this->descripcion='';
        $this->referencia='';
        $this->cantidad='';
        $this->peso='';
        $this->peso_total='';
        $this->precio='';
        $this->categoria_id='';
        $this->pieza_id='';
        $this->categorias=[];
        $this->updateMode=false;
    }

    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'referencia' => 'required',
            'cantidad' => 'required',
            'peso' => 'required',
        ]);

            $obj=$this->model::updateOrCreate(
                [
                    'id' =>  ($this->pieza_id),
                    'categoria_id' =>  ($this->categoria_id)
                ],
                [
                    'nombre' => ($this->nombre),
                    'categoria_id' =>  ($this->categoria_id),
                    'descripcion' =>  ($this->descripcion),
                    'referencia' =>  ($this->referencia),
                    'cantidad' =>  ($this->cantidad),
                    'peso' =>  ($this->peso),
                    'precio' =>  ($this->precio),
                    'peso_total' =>  ($this->peso_total),
                ]);
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
            $this->resetInputFields();
            $this->emit('closeModal');

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->pieza_id = $id;
        $this->nombre = $obj->nombre;
        $this->categoria_id = $obj->categoria_id;
        $this->descripcion = $obj->descripcion;
        $this->referencia = $obj->referencia;
        $this->cantidad = $obj->cantidad;
        $this->peso = $obj->peso;
        $this->peso_total = $obj->peso_total;
    }

    public function editEstado($id)
    {
        $this->pieza_id = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updateEstado(){
        $obj = $this->model::find($this->pieza_id);
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
