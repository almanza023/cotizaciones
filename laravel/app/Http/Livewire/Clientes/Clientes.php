<?php

namespace App\Http\Livewire\Clientes;

use App\Models\Cliente;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Clientes extends Component
{
    use WithPagination;
    public $nombre, $tipo_doc, $telefono, $numero, $correo, $direccion,
    $cliente_id,  $updateMode=false;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=Cliente::class;

    public function render()    {

        $data=$this->model::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        return view('livewire.clientes.clientes', compact('data'));
    }

    public function resetInputFields(){
        $this->nombre='';
        $this->tipo_doc='';
        $this->numero='';
        $this->correo='';
        $this->telefono='';
        $this->direccion='';
        $this->cliente_id='';
        $this->updateMode=false;
    }

    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
            'numero' => 'required',
            'tipo_doc' => 'required',
        ]);

            $cliente=$this->model::updateOrCreate(
                [
                    'id' =>  ($this->cliente_id)
                ],
                [
                    'nombre' => ($this->nombre),
                    'tipo_doc' =>  ($this->tipo_doc),
                    'numero' =>  ($this->numero),
                    'telefono' =>  ($this->telefono),
                    'correo' =>  ($this->correo),
                    'direccion' =>  ($this->direccion),
                ]);
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
            $this->resetInputFields();
            $this->emit('closeModal');

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->cliente_id = $id;
        $this->nombre = $obj->nombre;
        $this->tipo_doc = $obj->tipo_doc;
        $this->telefono = $obj->telefono;
        $this->correo = $obj->correo;
        $this->direccion = $obj->direccion;
        $this->numero = $obj->numero;
        $this->estado = $obj->estado;
    }

    public function editEstado($id)
    {
        $this->cliente_id = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updateEstado(){
        $obj = $this->model::find($this->cliente_id);

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
