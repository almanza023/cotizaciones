<?php

namespace App\Http\Livewire\Historial;

use App\Models\Huella;
use App\Models\Observacion;
use App\Models\ProfesionalUnidad;
use Livewire\Component;
use Livewire\WithPagination;

class Historial extends Component
{
    use WithPagination;

    public $i = 1;
    public $perPage = 20;
    public $search = '';
    public $orderBy = 'id_focalizacion';
    public $orderAsc = true;
    public $detalle, $editar=false;

    public $tipodocj, $numdocj, $primernomj, $primerapej, $direccion, $telefono, $integrantes, $fechavin;
    public $observaciones, $obs1, $obs2, $visible=false;

    private $model = Huella::class;

    public function render()
    {
        $tipo=auth()->user()->rol;
        $doc=auth()->user()->documento;
        $profesionalUnidad=ProfesionalUnidad::getProfesional($doc);
        $unidad=$profesionalUnidad->unidad->nombre;
        $data = $this->model::search($unidad, $tipo, $this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);
        if($this->obs1=='J) OTRO'){
            $this->visible=true;
        }else{
            $this->visible=false;
        }
        return view('livewire.historial.historial', compact('data'));
    }

    public function edit($id){
        $this->detalle=Huella::find($id);
        if(!empty($this->detalle)){
            $this->observaciones=Observacion::getActive();
            $this->tipodocj=$this->detalle->tip_doca;
            $this->numdocj=$this->detalle->num_doca;
            $this->primernomj=$this->detalle->primer_noma;
            $this->primerapej=$this->detalle->primer_apea;
            $this->direccion=$this->detalle->direcciona;
            $this->telefono=$this->detalle->telefonoa;
            $this->integrantes=$this->detalle->integrantes;
            $this->fechavin=$this->detalle->fechavin;
            $this->obs1=$this->detalle->observacion1;
            $this->obs2=$this->detalle->observacion2;
        }
    }
    public function habilitar(){
        $this->editar=true;
    }

    public function update(){

        if($this->detalle->docpro==auth()->user()->documento){
            if($this->detalle->programa=="SI"){
                $validatedDate = $this->validate([
                    'tipodocj' => 'required',
                    'numdocj' => 'required',
                    'primernomj' => 'required',
                    'primerapej' => 'required',
                    'telefono' => 'required|digits:10',
                    'direccion' => 'required',
                    'integrantes' => 'required',
                    'fechavin' => 'required|date',
                ]);
                $this->detalle->tip_doca=$this->tipodocj;
                $this->detalle->num_doca=$this->numdocj;
                $this->detalle->primer_noma=strtoupper($this->primernomj);
                $this->detalle->primer_apea=strtoupper($this->primerapej);
                $this->detalle->direcciona=strtoupper($this->direccion);
                $this->detalle->telefonoa=$this->telefono;
                $this->detalle->integrantes=$this->integrantes;
                $this->detalle->fechavin=$this->fechavin;
                $this->detalle->save();
            }else{
                $validated = $this->validate([
                    'obs1' => 'required',
                ]);
                $this->detalle->observacion1=strtoupper($this->obs1);
                if($this->obs1=='J) OTRO'){
                    $validated = $this->validate([
                        'obs2' => 'required',
                    ]);
                $this->detalle->observacion2=strtoupper($this->obs2);
                }
                $this->detalle->save();
            }
            session()->flash('message', 'SE ACTUALIZARON LOS DATOS DEL ID '.$this->detalle->id_focalizacion.' EXITOSAMENTE.');

            $this->emit('closeModal');
        }else{
            session()->flash('error', 'NO PUEDE ACTUALIZAR DATOS QUE INGRESO OTRO PROFESIONAL AL ID '.$this->detalle->id_focalizacion);
            $this->emit('closeModal');
        }

    }

}
