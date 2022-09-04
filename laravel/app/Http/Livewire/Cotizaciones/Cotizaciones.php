<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\Andamio;
use App\Models\Cliente;
use App\Models\Consecutivo;
use App\Models\Contacto;
use App\Models\Cotizacion;
use App\Models\DetalleAndamio;
use App\Models\DetalleCotizacion;
use Carbon\Carbon;
use Livewire\Component;

class Cotizaciones extends Component
{
    public  $cotizacion_id, $cliente_id,  $numero, $nombre_cliente, $documento_cliente, $solicitado, $correo, $telefono, $proyecto;
    public  $descripcion, $fecha, $vencimiento, $forma_pago, $tipo, $entrega, $isStore, $detalles, $cantidad;
    public  $dias, $porcentaje, $valor, $iva, $subtotal, $total, $total_peso;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;


    public function render()
    {
        $clientes=Cliente::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);
        return view('livewire.cotizaciones.cotizaciones', compact('clientes'));
    }

    public function selectCliente($id){
       $cliente=Cliente::find($id);
       if(!empty($cliente)){
        $this->cliente_id=$id;
        $this->nombre_cliente=$cliente->nombre;
        $this->documento_cliente=$cliente->numero;
       }else{
        $this->nombre_cliente='';
        $this->documento_cliente='';
       }
    }

    public function store(){
        $validated = $this->validate([
            'solicitado' => 'required',
            'proyecto' => 'required',
            'telefono' => 'required',
            'forma_pago' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required|date'
        ]);
        $cons=Consecutivo::getActive();
        $cod=$cons->cotizaciones+1;
        $this->codigo=$cod;
        $cons->cotizaciones=$cod;
        $cons->save();
        $vencimiento = Carbon::createFromFormat('Y-m-d', $this->fecha);
        $vencimiento->addDays(30);
            $obj=Cotizacion::updateOrCreate(
                [
                    'id' =>  ($this->cotizacion_id),
                ],
                [
                    'cliente_id' => ($this->cliente_id),
                    'numero' => ($this->codigo),
                    'contacto' =>  ($this->solicitado),
                    'proyecto' =>  ($this->proyecto),
                    'tipo' =>  ($this->tipo),
                    'descripcion' =>  ($this->descripcion),
                    'entrega' =>  ($this->entrega),
                    'telefono' =>  ($this->telefono),
                    'correo' =>  ($this->correo),
                    'forma_pago' =>  ($this->forma_pago),
                    'fecha' =>  ($this->fecha),
                    'vencimiento' =>  ($vencimiento),
                    'dias' =>  ($this->dias),
                    'valor_kg' =>  ($this->valor),
                ]);
                if($obj){
                    $cont=Contacto::created([
                        'nombre'=>$this->solicitado,
                        'numero'=>$this->numero,
                        'telefono'=>$this->telefono,
                        'proyecto'=>$this->proyecto,
                    ]);
                    $this->isStore=true;
                    $this->cotizacion_id=$obj->id;
                    $idc=$this->cotizacion_id;
                    session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
                    return redirect()->route('cotizacion.detalles', $idc);
                }
        }



    public function add($id, $peso){
        $validated = $this->validate([
            'cantidad' => 'required'
        ]);
        $obj=DetalleCotizacion::updateOrCreate(
            [
                'cotizacion_id' =>  ($this->cotizacion_id),
                'andamio_id' =>  ($this->id),
            ],
            [
                'andamio_id' => ($id),
                'cotizacion_id' => ($this->cotizacion_id),
                'cantidad' =>  ($this->cantidad),
                'peso' =>  ($peso),
                'peso_total' =>  ($peso * $this->cantidad),
            ]);
        $this->cantidad='';
        $this->detalles=DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, $this->categoria_id);
    }

    public function quitar($id){
        $det=DetalleCotizacion::find($id);
        $det->delete();
        $this->detalles=DetalleCotizacion::getCotizacion($this->cotizacion_id, 1, $this->categoria_id);
    }

    public function update(){

        $validated = $this->validate([
            'iva' => 'required',
            'dias' => 'required',
            'valor' => 'required'
        ]);

        $obj=Cotizacion::find($this->cotizacion_id);
        $obj->iva=$this->iva;
        $obj->porcentaje=$this->porcentaje;
        $obj->subtotal=$this->subtotal;
        $obj->total=$this->total;
        $obj->dias=$this->dias;
        $obj->peso=$this->total_peso;
        $obj->estado=1;
        $obj->save();
        session()->flash('message', 'DATOS REGISTRADOS EXITOSAMENTE.');
        redirect()->route('cotizaciones');
    }





}
