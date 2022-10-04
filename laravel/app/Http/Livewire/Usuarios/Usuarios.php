<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\Cliente;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Usuarios extends Component
{
    use WithPagination;
    public $nombre, $numero, $correo, $telefono, $rol, $clave,
    $usuario_id,  $updateMode=false;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=User::class;

    public function render()    {

        $data=$this->model::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        return view('livewire.usuarios.usuarios', compact('data'));
    }

    public function resetInputFields(){
        $this->nombre='';
        $this->numero='';
        $this->correo='';
        $this->telefono='';
        $this->clave='';
        $this->rol='';
        $this->usuario_id='';
        $this->updateMode=false;
    }

    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
            'numero' => 'required',
            'rol' => 'required',
        ]);

           if((empty($this->clave))){
            $this->model::updateOrCreate(
                [
                    'id' =>  ($this->usuario_id)
                ],
                [
                    'name' => ($this->nombre),
                    'documento' =>  ($this->numero),
                    'email' =>  ($this->correo),
                    'telefono' =>  ($this->telefono),
                    'rol' =>  ($this->rol),
                ]);
           }else{
            $this->model::updateOrCreate(
                [
                    'id' =>  ($this->usuario_id)
                ],
                [
                    'name' => ($this->nombre),
                    'documento' =>  ($this->numero),
                    'email' =>  ($this->correo),
                    'telefono' =>  ($this->telefono),
                    'password' =>  Hash::make($this->clave),
                    'rol' =>  ($this->rol),
                ]);
           }
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
            $this->resetInputFields();
            $this->emit('closeModal');

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->usuario_id = $id;
        $this->nombre = $obj->name;
        $this->numero = $obj->documento;
        $this->telefono = $obj->telefono;
        $this->correo = $obj->email;
        $this->estado = $obj->estado;
        $this->rol = $obj->rol;
    }

    public function editEstado($id)
    {
        $this->usuario_id = $id;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updateEstado(){
        $obj = $this->model::find($this->usuario_id);
        if($obj->estado==1){
            $obj->estado=0;
            $obj->save();
        }else{
            $obj->estado=1;
            $obj->save();
        }
        $this->emit('closeModal');
        session()->flash('message', 'ESTADO ACTUALIZADO EXITOSAMENTE');



    }

}
