<?php

namespace App\Http\Livewire\RegistroAndamios;

use App\Models\Andamio;
use App\Models\Consecutivo;
use App\Models\DetalleAndamio;
use App\Models\Pieza;
use Livewire\Component;

class RegistroAndamios extends Component
{
    public  $andamio_id, $cantidad, $peso, $peso_total, $codigo, $codigo_andamio,  $nombre,
    $descripcion, $longitud, $detalles, $isStore=false;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {
        $this->doc=auth()->user()->documento;
        $piezas=Pieza::search($this->search,'')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        return view('livewire.registro-andamios.registro-andamios', compact('piezas'));
    }

    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
            'longitud' => 'required'
        ]);
        $cons=Consecutivo::getActive();
        $cod=$cons->andamios+1;
        $this->codigo=$cod;
        $cons->andamios=$cod;
        $cons->save();

            $obj=Andamio::updateOrCreate(
                [
                    'id' =>  ($this->andamio_id),
                ],
                [
                    'nombre' => ($this->nombre),
                    'codigo' =>  ($this->codigo),
                    'descripcion' =>  ($this->descripcion),
                    'longitud' =>  ($this->longitud),
                ]);
                $this->isStore=true;
                $this->andamio_id=$obj->id;
                session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');

    }

    public function add($id, $peso){
        $obj=DetalleAndamio::updateOrCreate(
            [
                'andamio_id' =>  ($this->andamio_id),
                'pieza_id' =>  ($id),
            ],
            [
                'andamio_id' => ($this->andamio_id),
                'pieza_id' =>  ($id),
                'cantidad' =>  ($this->cantidad),
                'peso' =>  ($peso),
                'peso_total' =>  ($peso * $this->cantidad),
            ]);
        $this->cantidad='';
        $this->detalles=DetalleAndamio::getAndamio($this->andamio_id);
        $piezas=0;
        $totalpeso=0;
       foreach ($this->detalles as $item) {
          $piezas+=1;
          $totalpeso+=$item->peso;
       }
       $and=Andamio::find($this->andamio_id);
       $and->piezas=$piezas;
       $and->peso=$and->peso+$totalpeso;
       $and->save();

    }

    public function quitar($id){
        $det=DetalleAndamio::find($id);
        $and=Andamio::find($det->andamio_id);
        $and->piezas=$and->piezas-1;
        $and->peso=$and->peso+$det->peso;
        $and->save();
        $det->delete();
        $this->detalles=DetalleAndamio::getAndamio($this->andamio_id);
    }

    public function buscar(){
        $obj=Andamio::getByCodigo($this->codigo_andamio);
        if(!empty($obj)){
            $this->nombre=$obj->nombre;
            $this->codigo=$obj->codigo;
            $this->longitud=$obj->longitud;
            $this->descripcion=$obj->descripcion;
            $this->detalles=DetalleAndamio::getAndamio($obj->id);
            $this->isStore=true;
        }else{
            $this->detalles='';
            $this->isStore=false;
            $this->nombre='';
            $this->codigo='';
            $this->longitud='';
            $this->descripcion='';
        }

    }




}
