<?php

namespace App\Http\Livewire\Soportes;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Soporte;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Soportes extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $proyecto, $proyecto_id, $nombre, $numero, $descripcion, $ruta, $fecha, $iid,
    $usuario_id,  $updateMode=false;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=Soporte::class;

    public function mount($id)
    {
        $this->proyecto_id = $id;
        $this->proyecto=Proyecto::find($id);
        if(!empty($cot)){
            if($cot->estado==1 || $cot->estado==2){
                //session()->flash('message', 'LA COTIZACION YA SE ENCUENTRA CERRADA');
                //return redirect()->route('cobros');
            }
        }else{
            //session()->flash('message', 'NO EXISTE CODIGO');
            //return redirect()->route('cobros');
        }
    }

    public function render()    {
        $this->usuario_id=auth()->user()->id;
        $data=$this->model::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        return view('livewire.soportes.soportes', compact('data'));
    }

    public function resetInputFields(){
        $this->proyecto_id='';
        $this->usuario_id='';
        $this->nombre='';
        $this->descripcion='';
        $this->ruta='';
        $this->fecha='';
        $this->iid='';
        $this->updateMode=false;
    }

    public function save(){
        $validated = $this->validate([
            'nombre' => 'required',
            'ruta' => 'required',
            'fecha' => 'required|date',
            'proyecto_id' => 'required',
        ]);
        $name=$this->proyecto_id.'_'.$this->nombre.'_'.$this->fecha.'.'.$this->ruta->getClientOriginalExtension();
        $path=$this->proyecto->nombre.'/'.$name;
        if(empty($this->iid)){
            $this->ruta->storeAs($this->proyecto->nombre, $name, 'public');
        }else{
            Storage::delete(public_path($path));
            Soporte::find($this->iid)->delete();
        }
            $this->model::create(
                [
                    'proyecto_id' => ($this->proyecto_id),
                    'nombre' => ($this->nombre),
                    'descripcion' =>  ($this->descripcion),
                    'archivo_base'=>$this->ruta->getClientOriginalName(),
                    'ruta' =>  ($path),
                    'fecha' =>  ($this->fecha),
                    'usuario_id' =>  ($this->usuario_id),
                ]);
            session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
            $this->resetInputFields();
            $this->emit('closeModal');

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $obj = $this->model::find($id);
        $this->proyecto_id = $obj->proyecto_id;
        $this->nombre = $obj->nombre;
        $this->descripcion = $obj->descripcion;
        $this->fecha = $obj->fecha;
        $this->ruta = $obj->archivo_base;
        $this->estado = $obj->estado;
    }

    public function editEstado($id)
    {
        $this->iid = $id;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updateEstado(){
        $obj = $this->model::find($this->iid);
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
