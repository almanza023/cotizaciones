<?php

namespace App\Http\Livewire\Facturas;

use App\Models\CategoriaProyecto;
use App\Models\Cobro;
use App\Models\Empresa;
use App\Models\Factura;
use App\Models\Facturacion;
use App\Models\Proyecto;
use App\Models\Subcobro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GenerarFactura extends Component
{
    public $proyecto_id, $categoria_id, $usuario_id, $data, $valor, $detalles=[], $sel_categoria,
    $proyecto, $fecha1, $fecha2, $pesototal, $iva, $subtotal, $total, $porcentaje, $total_subtotal, $total_iva, $total_total;


    public function mount($id)
    {
        $this->proyecto_id = $id;
        $this->proyecto=Proyecto::find($id);
        $this->valor=$this->proyecto->cotizacion->valor_kg;
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
    public function render()
    {
        $this->porcentaje=Empresa::getPorcentaje()/100;
        $this->usuario_id=auth()->user()->id;
        $this->categorias=CategoriaProyecto::getCategoriasByProyecto($this->proyecto_id);

        if(!empty($this->valor)){
            $this->subtotal= $this->pesototal * $this->valor;
            $this->iva=round($this->subtotal * ($this->porcentaje), 2);
            $this->total = $this->subtotal + $this->iva;
        }else{
            $this->subtotal=0;
            $this->iva=0;
            $this->total=0;
        }

        return view('livewire.facturas.generar-factura');
    }

    public function consultar(){
        $validated = $this->validate([
            'categoria_id' => 'required',
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
        ]);
        $this->pesototal=0;
        $this->data=Cobro::getFechasByEstado($this->proyecto_id, $this->categoria_id, $this->fecha1, $this->fecha2, 1);

        foreach ($this->data as $item) {
            $this->pesototal=$this->pesototal + $item->pesodiatotal;
            $this->total_subtotal +=$item->subtotal;
            $this->total_iva +=$item->iva;
            $this->total_total +=$item->total;
        }

    }
    public function ver($id, $categoria){
        $this->sel_categoria=$categoria;
        $this->detalles=Subcobro::getDetalles($id);
    }

    public function guardar(){

        $validated = $this->validate([
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
            'total'=>    'required'
        ]);
        $tot=0;
        $sub=0;
        $iva=0;
        if(empty($this->total)){
            $tot=$this->total_total;
        }else{
            $tot=$this->total;
        }

        if(empty($this->iva)){
            $tot=$this->total_iva;
        }else{
            $tot=$this->iva;
        }

        if(empty($this->subtotal)){
            $tot=$this->total_subtotal;
        }else{
            $tot=$this->subtotal;
        }

       if($tot>0 ){
        DB::beginTransaction();
        $numero= Factura::select("id")->where('proyecto_id', $this->proyecto_id)->latest()->first();
        if(empty($numero)){
            $numero=1;
        }else{
            $numero=$numero->id+1;
        }
        $fact=Factura::create([
            'proyecto_id'=>$this->proyecto_id,
            'categoria_id'=>$this->categoria_id,
            'usuario_id'=>$this->usuario_id,
            'numero'=>$numero,
            'fecha_gen'=>Carbon::now()->format('Y-m-d'),
            'fecha1'=>$this->fecha1,
            'fecha2'=>$this->fecha2,
            'subtotal'=>$sub,
            'valor_kg'=>$this->valor,
            'porcentaje'=>$this->porcentaje,
            'peso'=>$this->pesototal,
            'iva'=>$iva,
            'total'=>$tot,
        ]);

        foreach ($this->data as $item) {
            //Actualizar estado de Cobro (facturado)
            $item->factura_id=$fact->id;
            $item->estado=2;
            $item->save();
        }

        try {
            DB::commit();
            session()->flash('message', 'FACTURA REALIZADA EXITOSAMENTE');
            return redirect()->route('proyectos.opciones', $this->proyecto_id);
         } catch (\Exception $e) {
            DB::rollback();
            session()->flash('advertencia', $e->getMessage());
        }
       }else{
        session()->flash('advertencia', 'NO EXISTEN COBROS PARA REALIZAR FACTURA');

       }
    }
}
