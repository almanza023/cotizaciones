<?php

namespace App\Http\Livewire\ListadoCotizaciones;


use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\Reportes\ReporteCotizacion;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ListadoCotizaciones extends Component
{
    use WithPagination;

    public $cotizacion_id;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    private $model=Cotizacion::class;
    public function render()
    {
        $data=$this->model::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);
        return view('livewire.listado-cotizaciones.listado-cotizaciones', compact('data'));
    }

    public function editEstado($id)
    {
        $this->cotizacion_id = $id;
    }

    public function updateEstado(){
        $obj = $this->model::find($this->cotizacion_id);

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

    public function duplicar($id){
        $cotizacion=Cotizacion::find($id);
        $detalles=DetalleCotizacion::getCotizacionGeneral($id);
        if(!empty($cotizacion) && !empty($detalles)){
            $date = Carbon::now()->format('Y-m-d');
                $nuevaCotizacion=new Cotizacion();
                $nuevaCotizacion->cliente_id=$cotizacion->cliente_id;
                $nuevaCotizacion->usuario_id=$cotizacion->usuario_id;
                $nuevaCotizacion->numero=$cotizacion->numero;
                $nuevaCotizacion->contacto=$cotizacion->contacto;
                $nuevaCotizacion->proyecto=$cotizacion->proyecto;
                $nuevaCotizacion->tipo=$cotizacion->tipo;
                $nuevaCotizacion->entrega=$cotizacion->entrega;
                $nuevaCotizacion->telefono=$cotizacion->telefono;
                $nuevaCotizacion->correo=$cotizacion->correo;
                $nuevaCotizacion->forma_pago=$cotizacion->forma_pago;
                $nuevaCotizacion->fecha=$date;
                $nuevaCotizacion->vencimiento=$cotizacion->vencimiento;
                $nuevaCotizacion->subtotal=$cotizacion->subtotal;
                $nuevaCotizacion->subtotal2=$cotizacion->subtotal2;
                $nuevaCotizacion->dias=$cotizacion->dias;
                $nuevaCotizacion->valor_kg=$cotizacion->valor_kg;
                $nuevaCotizacion->iva=$cotizacion->iva;
                $nuevaCotizacion->porcentaje=$cotizacion->porcentaje;
                $nuevaCotizacion->total=$cotizacion->total;
                $nuevaCotizacion->peso=$cotizacion->total;
                $nuevaCotizacion->estado=1;
                $nuevaCotizacion->copiado='SI';
                $nuevaCotizacion->save();

                    foreach ($detalles as $item) {
                        $detalle=new DetalleCotizacion();
                        $detalle->cotizacion_id=$nuevaCotizacion->id;
                        $detalle->andamio_id=$item->andamio_id;
                        $detalle->pieza_id=$item->pieza_id;
                        $detalle->categoria_id=$item->categoria_id;
                        $detalle->cantidad=$item->cantidad;
                        $detalle->dias=$item->dias;
                        $detalle->subtotal=$item->subtotal;
                        $detalle->iva=$item->iva;
                        $detalle->precio=$item->precio;
                        $detalle->porcentaje=$item->porcentaje;
                        $detalle->total=$item->total;
                        $detalle->peso=$item->peso;
                        $detalle->peso_total=$item->peso_total;
                        $detalle->estado=1;
                        $detalle->save();
                    }
            session()->flash('message', 'COTIZACION COPIADA EXITOSAMENTE');
        }
    }







}
