<?php

namespace App\Http\Livewire\Facturas;

use App\Models\CategoriaProyecto;
use App\Models\Cobro;
use App\Models\Factura;
use App\Models\Facturacion;
use App\Models\Proyecto;
use App\Models\Subcobro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GenerarFactura extends Component
{
    public $proyecto_id, $categoria_id, $usuario_id, $data, $valor,
    $proyecto, $fecha1, $fecha2, $pesototal, $iva, $subtotal, $total, $porcentaje;


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
        $this->porcentaje=(0.19);
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
        }
    }

    public function guardar(){

        $validated = $this->validate([
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
            'total'=>    'required'
        ]);

        DB::beginTransaction();
        $numero=1;
        $fact=Factura::create([
            'proyecto_id'=>$this->proyecto_id,
            'usuario_id'=>$this->usuario_id,
            'numero'=>$numero,
            'fecha_gen'=>Carbon::now()->format('Y-m-d'),
            'fecha1'=>$this->fecha1,
            'fecha2'=>$this->fecha2,
            'subtotal'=>$this->subtotal,
            'valor_kg'=>$this->valor,
            'porcentaje'=>$this->porcentaje,
            'peso'=>$this->pesototal,
            'iva'=>$this->iva,
            'total'=>$this->total,
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
    }
}
