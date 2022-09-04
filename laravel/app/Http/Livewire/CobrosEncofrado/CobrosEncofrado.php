<?php

namespace App\Http\Livewire\CobrosEncofrado;

use App\Models\Cobro;
use App\Models\CobroEncofrado;
use App\Models\Consecutivo;
use App\Models\ConsecutivoProyecto;
use App\Models\DetalleEntrega;
use App\Models\Entrega;
use App\Models\EntregaProyecto;
use App\Models\Proyecto;
use App\Models\SubcobroEncofrado;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CobrosEncofrado extends Component
{
    public $proyecto_id, $usuario_id, $matriz=[],
      $proyecto, $fecha1, $fecha2, $dias, $date, $nuevaFecha;


    public function mount($id)
    {
        $this->proyecto_id = $id;
        $this->proyecto=Proyecto::find($id);
    }
    public function render()
    {
        $this->usuario_id=auth()->user()->id;
        return view('livewire.cobros-encofrado.cobros-encofrado');
    }

    public function consultar(){

        $validated = $this->validate([
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
        ]);
        $this->matriz=EntregaProyecto::getEntregasFechas($this->proyecto_id, $this->fecha1, $this->fecha2, 1);
        $this->date=Carbon::now()->format('Y-m-d');
        $this->nuevaFecha=Carbon::createFromDate($this->fecha2)->addDay()->format('Y-m-d');
        $this->dias=Carbon::createFromDate($this->fecha1)->diffInDays(Carbon::createFromDate($this->fecha2)) + 1;
    }

    public function guardar(){

        $validated = $this->validate([
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
        ]);

        DB::beginTransaction();
        try {

            $conse=Consecutivo::aumentarConsEntregas();
            $conseSubcobros=ConsecutivoProyecto::getSubcobros($this->proyecto_id)+1;
            $numeroEntrega=Entrega::aumentaNumeroEntrega($this->proyecto_id);

            $this->proyecto->ultima_entrega=$numeroEntrega;
            $this->proyecto->ultima_fecha=$this->nuevaFecha;
            $this->proyecto->save();
             //generar Un Cobro
             $cobro=CobroEncofrado::create([
                'proyecto_id'=>$this->proyecto_id,
                'usuario_id'=>$this->usuario_id,
                'fecha_corte'=>$this->nuevaFecha,
                'fecha1'=>$this->fecha1,
                'fecha2'=>$this->fecha2,
                'dias'=>$this->dias,
            ]);

             //Guardar Nueva Entrega (Detalles)
             $entregaDetalle=Entrega::create([
                'cotizacion_id'=>$this->proyecto->cotizacion->id,
                'proyecto_id'=>$this->proyecto_id,
                'usuario_id'=>$this->usuario_id,
                'fecha'=>$this->nuevaFecha,
                'codigo'=>$conse->entregas,
                'numero'=>$numeroEntrega,
                'contacto'=>($this->proyecto->cotizacion->contacto)
                ]);

             $piezas=0;
             $pesototal=0;
             $cantidadtotal=0;
             $pesodiatotal=0;
            foreach ($this->matriz as $item) {
                $item->estado=0;
                $item->save();
                $peso=$item->pieza->peso;
                $pesodia=$this->dias * $peso * $item->restante;
                //Generar Subcobros
                $subcobro=SubcobroEncofrado::create([
                    'pieza_id'=>$item->pieza_id,
                    'proyecto_id'=>$this->proyecto_id,
                    'cobro_id'=>$cobro->id,
                    'numero'=>$conseSubcobros,
                    'cantidad'=>$item->restante,
                    'peso'=>$peso,
                    'dias'=>$this->dias,
                    'fecha1'=>$this->fecha1,
                    'fecha2'=>$this->fecha2,
                    'pesodia'=>$pesodia
                ]);

                //Guardar detalles de nueva entrega
                $det=DetalleEntrega::create([
                    'entrega_id'=>$entregaDetalle->id,
                    'pieza_id'=>$item->pieza_id,
                    'cantidad'=>$item->restante,
                    'fecha_entrega'=>$this->nuevaFecha,
                 ]);

                //Generar Nueva Entrega General
                EntregaProyecto::create(
                    [
                        'proyecto_id' =>  ($this->proyecto_id),
                        'pieza_id' =>  ($item->pieza_id),
                        'numero' =>  ($numeroEntrega),
                        'entregadas' => ($item->restante),
                        'restante' => ($item->restante),
                        'fecha'=>$this->nuevaFecha
                    ]);

                //Registrar Subcorte
                 $piezas++;
                 $pesototal=$pesototal+$peso;
                 $cantidadtotal=$cantidadtotal+$item->restante;
                 $pesodiatotal=$pesodiatotal+$pesodia;
                 $pesodia=0;

            }
             //Actualizar subcobro
             $cobro->piezas=$piezas;
             $cobro->pesototal=$pesototal;
             $cobro->cantidadtotal=$cantidadtotal;
             $cobro->pesodiatotal=$pesodiatotal;
             $cobro->save();
             $const=ConsecutivoProyecto::getProyectoId($this->proyecto_id);
             $const->subcobros=$conseSubcobros;
             $const->save();
            DB::commit();
            session()->flash('message', 'COBRO MATERIAL ENCOFRADO REALIZADO EXITOSAMENTE');
            return redirect()->route('proyectos.opciones', $this->proyecto_id);
         } catch (\Exception $e) {
            DB::rollback();
            session()->flash('advertencia', $e->getMessage());
        }
    }
}
