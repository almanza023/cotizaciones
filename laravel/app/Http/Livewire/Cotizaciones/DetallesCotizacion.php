<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Http\Livewire\Andamios\Andamios;
use App\Models\Andamio;
use App\Models\Categoria;
use App\Models\Consecutivo;
use App\Models\Cotizacion;
use App\Models\DetalleAndamio;
use App\Models\DetalleCotizacion;
use App\Models\Empresa;
use App\Models\Pieza;
use Livewire\Component;

class DetallesCotizacion extends Component
{
    public $cotizacion_id, $detPiezas=[];
    public  $andamio_id, $cantidad, $peso, $peso_total, $codigo, $codigo_andamio,  $nombre,
    $descripcion, $categorias, $categoria_id='', $detalles, $isStore=false, $listado_andamios, $dias, $valor;
    public $precio, $porcentaje, $canPiezas=0, $pesototal=0, $iva, $subtotal, $total;
    public $totales_cot, $tipo_andamio, $cantidad_andamio, $andamios=[];

    public $ndias, $totalkgdia=0;
    public $cantidad2, $valor2, $dias2, $total2, $dias3=1;



    public $perPage = 100;
    public $search = '', $search2='';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function mount($id)
    {
        $this->cotizacion_id = $id;
        $cot=Cotizacion::find($this->cotizacion_id);
        if(!empty($cot)){
            if($cot->estado==1 || $cot->estado==2){
                //session()->flash('message', 'LA COTIZACION YA SE ENCUENTRA CERRADA');
                //return redirect()->route('cotizaciones');
            }
        }else{
            session()->flash('message', 'NO EXISTE CODIGO');
            return redirect()->route('cotizaciones');
        }

    }

    public function render()

    {

        $this->porcentaje=Empresa::getPorcentaje();
        $list_andamios=[];
        if(!empty($this->categoria_id) && $this->categoria_id<=2){
            $list_andamios=Andamio::searchActivos($this->search2, $this->categoria_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);;
            //dd($list_andamios);
            $this->listado_andamios=DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, $this->categoria_id);
            $totales=DetalleCotizacion::totales($this->cotizacion_id, $this->categoria_id);
            $this->canPiezas=$totales[0]->piezas;
            $this->pesototal=$totales[0]->peso;
            $this->totalkgdia=$totales[0]->kgdias;
        }
        if(!empty($this->categoria_id) && $this->categoria_id>2){
            $this->getDetalles();
        }

        if(empty($this->valor)){
            $this->subtotal='';
            $this->iva='';
            $this->total='';
        }

        if(!empty($this->totalkgdia) && !empty($this->valor) && ($this->categoria_id<=2)){
            $this->subtotal=$this->totalkgdia * $this->valor;
            $this->iva=$this->subtotal * ($this->porcentaje/100);
            $this->total=$this->subtotal + $this->iva;
        }
        if($this->categoria_id>2){
            $totales=DetalleCotizacion::totales($this->cotizacion_id, $this->categoria_id);
            $this->canPiezas=$totales[0]->piezas;
            $this->pesototal=$totales[0]->peso;
            $this->subtotal=$totales[0]->kgdias;
           if ($this->categoria_id<5) {
            $this->iva=$this->subtotal * ($this->porcentaje/100);
           }else{
               $this->iva=0;
           }
            $this->total=$this->subtotal + $this->iva;
        }
        $this->categorias=Categoria::getActive();
        $this->doc=auth()->user()->documento;
        $piezas=Pieza::search($this->search, $this->categoria_id, $this->tipo_andamio)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);


        //dd($andamios);
        $this->totales_cot=DetalleCotizacion::totalCotizacion($this->cotizacion_id);

        return view('livewire.cotizaciones.detalles-cotizacion', compact('piezas', 'list_andamios'));
    }
    public function store(){
        $validated = $this->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'ndias' => 'required',
        ]);
        $cons=Consecutivo::getActive();
        $cod=$cons->andamios+1;
        $this->codigo=$cod;
        $cons->andamios=$cod;
        $cons->save();
        $obj=Andamio::create(
                [
                    'nombre' => ($this->nombre),
                    'codigo' =>  ($this->codigo),
                    'categoria_id' =>  ($this->categoria_id),
                    'descripcion' =>  ($this->tipo_andamio),
                    'dias' =>  ($this->ndias),
                    'cantidad' =>  ($this->cantidad_andamio),
                ]);
                $this->isStore=true;
                $this->andamio_id=$obj->id;
        // Mostrar la modal de piezas
        $this->dispatchBrowserEvent('abrirModal');
    }

    public function add($id){
        $validated = $this->validate([
            'cantidad' => 'required',
        ]);

        $pieza=Pieza::find($id);

        if($this->categoria_id<=2){
            if($pieza->cantidad>0){
                $obj=DetalleAndamio::updateOrCreate(
                    [
                        'andamio_id' =>  ($this->andamio_id),
                        'pieza_id' =>  ($id),
                    ],
                    [
                        'andamio_id' => ($this->andamio_id),
                        'pieza_id' =>  ($id),
                        'cantidad' =>  ($this->cantidad * $this->cantidad_andamio),
                        'peso' =>  ($pieza->peso),
                        'peso_total' =>  ($pieza->peso * $this->cantidad * $this->cantidad_andamio),
                    ]);
            }else{
                session()->flash('advertencia', 'CANTIDAD NO ES VALIDA');
            }
        }else{
            if(($this->categoria_id==3 || $this->categoria_id==4) && empty($this->dias3)){
                session()->flash('error', 'CANTIDAD DE DÍAS ES OBLIGATORIO');
            }
            $subt=($pieza->precio * $this->cantidad*$this->dias3);
            $iva=$subt * ($this->porcentaje/100);
            $tot=$subt + $iva;
            $obj=DetalleCotizacion::updateOrCreate(
                [
                    'cotizacion_id' =>  ($this->cotizacion_id),
                    'pieza_id' =>  ($id),
                ],
                [
                    'categoria_id' =>  ($pieza->categoria_id),
                    'cotizacion_id' => ($this->cotizacion_id),
                    'pieza_id' => ($id),
                    'cantidad' =>  ($this->cantidad),
                    'peso' =>  ($pieza->peso),
                    'dias'=>$this->dias3,
                    'peso_total' =>  ($pieza->peso * $this->cantidad),
                    'precio' =>  ($pieza->precio),
                    'iva' =>  ($iva),
                    'porcentaje' =>  ($this->porcentaje),
                    'subtotal' =>  $subt,
                    'total' =>  $tot,
                    'estado'=>1
                ]);
        }
        $this->cantidad='';
        $this->search='';
        $this->getDetalles();
        if($this->categoria_id<=2){
        $piezas=0;
        $totalpeso=0;
        foreach ($this->detalles as $item) {
            $piezas+=$item->cantidad;
            $totalpeso+=($item->peso*$item->cantidad);
        }
        $and=Andamio::find($this->andamio_id);
        $and->piezas=$piezas;
        $and->peso=+$totalpeso;
        $and->kgdias=($totalpeso)*$and->dias;
        $and->save();
       }
       $this->getDetalles();
       session()->flash('advertencia', 'SE HA AGREADO UN REGISTRO');
    }

    public function add2($id){
        $validated = $this->validate([
            'cantidad2' => 'required',
            'dias2' => 'required',
            'valor2' => 'required',
        ]);
        $this->total2=$this->cantidad2 * $this->dias2* $this->valor2;
        $obj=DetalleCotizacion::updateOrCreate(
            [
                'cotizacion_id' =>  ($this->cotizacion_id),
                'pieza_id' =>  ($id),
            ],
            [
                    'categoria_id' => 5,
                    'cotizacion_id' => ($this->cotizacion_id),
                    'pieza_id' => ($id),
                    'cantidad' =>  ($this->cantidad2),
                    'dias' =>  ($this->dias2),
                    'precio' =>  ($this->valor2),
                    'subtotal' =>  $this->total2,
                    'total' =>  $this->total2,
                    'estado'=>1
            ]);
            session()->flash('message', 'SERVICIO AGREGADO A LA COTIZACION');

    }

    public function guardar(){
        if(!empty($this->detalles)){
            $obj=DetalleCotizacion::updateOrCreate(
                [
                    'cotizacion_id' =>  ($this->cotizacion_id),
                    'andamio_id' =>  ($this->andamio_id),
                ],
                [
                    'andamio_id' => ($this->andamio_id),
                    'categoria_id' => ($this->categoria_id),
                    'cantidad' =>  $this->cantidad_andamio
                ]);
                session()->flash('message', 'ANDAMIO REGISTRADO EXTISAMENTE');
                $this->detalles='';
                $this->isStore=false;
                $this->andamio_id='';
                $this->nombre='';
                $this->codigo='';
                $this->listado_andamios=DetalleCotizacion::getCotizacion($this->cotizacion_id,0, $this->categoria_id);
        }else{
            session()->flash('advertencia', 'NO HAY PIEZAS AGREGADAS AL ANDAMIO');
        }
    }

    public function quitarAndamio($id){
        $det=DetalleAndamio::find($id);
        $det->delete();
        $this->getDetalles();
        session()->flash('advertencia', 'SE HA ELIMINADO LA PIEZA DEL ANDAMIO');
    }

    public function verPiezas($id){
        $this->detPiezas='';
        $this->detPiezas=DetalleAndamio::getAndamio($id);

    }


    public function quitar($id){
        $det=DetalleCotizacion::find($id);
        $det->delete();
        $this->listado_andamios=DetalleCotizacion::getCotizacion($this->cotizacion_id,0,$this->categoria_id);
        session()->flash('advertencia', 'SE HA ELIMINADO REGISTRO DE LA COTIZACION');
    }

    public function buscar(){
        $obj=Andamio::getByCodigo($this->codigo_andamio);
        if(!empty($obj)){
            $this->nombre=$obj->nombre;
            $this->codigo=$obj->codigo;
            $this->longitud=$obj->longitud;
            $this->descripcion=$obj->descripcion;
            $this->getDetalles();
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

    public function finalizar(){
        $cot=Cotizacion::find($this->cotizacion_id);
        $cot->estado=1;
        $cot->usuario_id=auth()->user()->id;
        $cot->subtotal=$this->totales_cot['subtotal1'];
        $cot->peso=$this->totales_cot['peso'];
        $cot->subtotal2=$this->totales_cot['subtotal2'];
        $cot->iva=$this->totales_cot['iva'];

        $cot->porcentaje=$this->porcentaje;
        $cot->total=$this->totales_cot['total'];
        $cot->save();
        session()->flash('message', 'COTIZACION FINALIZADA EXITOSAMENTE');
        return redirect()->route('cotizaciones');

    }

    private function getDetalles(){
        if($this->categoria_id<=2){
            $this->detalles=DetalleAndamio::getAndamio($this->andamio_id);
        }else{
            $this->detalles=DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, $this->categoria_id);
        }
    }

    public function addAndamio($id, $peso){
        $validated = $this->validate([
            'dias' => 'required',
            'cantidad' => 'required',
            'precio' => 'required',
        ]);
        if($this->dias <= 0){
            return session()->flash('advertencia', 'N° DIAS NO VALIDO');
        }
        if($this->cantidad <= 0){
            return session()->flash('advertencia', 'CANTIDAD NO VALIDA');
        }
        if($this->precio <= 0){
            return session()->flash('advertencia', 'PRECIO NO VALIDO');
        }
        $subt=($peso * $this->cantidad * $this->precio);
        $iva=$subt * ($this->porcentaje/100);
        $tot=$subt + $iva ;
        $obj=DetalleCotizacion::create(
            [
                'categoria_id' =>  ($this->categoria_id),
                'cotizacion_id' => ($this->cotizacion_id),
                'andamio_id' => ($id),
                'cantidad' =>  ($this->cantidad),
                'peso' =>  ($peso),
                'dias'=>$this->dias,
                'peso_total' =>  ($peso * $this->cantidad),
                'precio' =>  ($this->precio),
                'iva' =>  ($iva),
                'porcentaje' =>  ($this->porcentaje),
                'subtotal' =>  $subt,
                'total' =>  $tot,
                'estado'=>1
            ]);
        $this->dias='';
        $this->precio='';
        $this->cantidad='';
        $this->dispatchBrowserEvent('cerarModal');
        session()->flash('message', 'ANDAMIO AGREGADO A COTIZACION EXITOSAMENTE');
        }


    public function agregarCot(){
        $validated = $this->validate([
            'valor' => 'required',
            'subtotal' => 'required',
            'iva' => 'required',
            'total' => 'required',
        ]);
        //Guardar Valor del Kg para toda la cotización
        $cot=Cotizacion::find($this->cotizacion_id);
        $cot->valor_kg=$this->valor;
        $cot->save();

        $dc=DetalleCotizacion::getCotizacion($this->cotizacion_id, 0, $this->categoria_id);
        foreach ($dc as $item) {
          if($item->estado==0){
            $item->andamio->valor=$this->valor;
            $item->andamio->save();
            $subt=($item->andamio->kgdias * $this->valor);
            $iva= $subt * ($this->porcentaje/100);
            $tot=$subt+$iva;

            $item->peso_total=$item->andamio->peso;
            $item->subtotal=$subt;
            $item->porcentaje=$this->porcentaje;
            $item->iva=$iva;
            $item->total=$tot;
            $item->estado=1;
            $item->save();
          }
        }
        $this->subtotal='';
        $this->iva='';
        $this->total='';
        $this->valor='';
        session()->flash('message', 'ANDAMIO(S) AGREGADOS A COTIZACION');
    }

}
