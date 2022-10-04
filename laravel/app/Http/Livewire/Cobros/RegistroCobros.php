<?php

namespace App\Http\Livewire\Cobros;

use App\Models\CategoriaProyecto;
use App\Models\Cobro;
use App\Models\Consecutivo;
use App\Models\ConsecutivoProyecto;
use App\Models\DetalleEntrega;
use App\Models\Empresa;
use App\Models\Entrega;
use App\Models\EntregaProyecto;
use App\Models\Pieza;
use App\Models\Proyecto;
use App\Models\Subcobro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistroCobros extends Component
{
    public $proyecto_id, $usuario_id, $matriz=[], $categoria_id, $porcentaje,
    $proyecto, $fecha1, $fecha2, $dias, $date, $nuevaFecha, $total=0;


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
    public function render()
    {
        if(!empty($this->categoria_id)){
            $procat=CategoriaProyecto::getId($this->proyecto_id, $this->categoria_id);
        }
        if(!empty($procat)){
            $this->fecha1=$procat->ultima_fecha;
        }
        $this->porcentaje=Empresa::getPorcentaje();
        $this->categorias=CategoriaProyecto::getCategoriasByProyecto($this->proyecto_id);
        $this->usuario_id=auth()->user()->id;
        return view('livewire.cobros.registro-cobros');
    }

    public function consultar(){

        $validated = $this->validate([
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
        ]);
        $this->total=EntregaProyecto::getTotalPiezas($this->proyecto_id, $this->categoria_id, 1);
        $this->matriz=EntregaProyecto::getEntregasFechas($this->proyecto_id, $this->fecha1, $this->fecha2, $this->categoria_id, 1);

        $this->date=Carbon::now()->format('Y-m-d');
        $this->nuevaFecha=Carbon::createFromDate($this->fecha2)->addDay()->format('Y-m-d');
        $this->dias=Carbon::createFromDate($this->fecha1)->diffInDays(Carbon::createFromDate($this->fecha2)) + 1;
    }

    public function guardar(){

        $validated = $this->validate([
            'categoria_id' => 'required',
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
        ]);

        DB::beginTransaction();
        try {

            $conse=Consecutivo::aumentarConsEntregas();
            $conseSubcobros=ConsecutivoProyecto::getSubcobros($this->proyecto_id)+1;
            $numeroEntrega=Entrega::aumentaNumeroEntrega($this->proyecto_id);

            //Actualizar Proyecto CATEGORIA
            $procat=CategoriaProyecto::getId($this->proyecto_id, $this->categoria_id);
            $procat->ultima_fecha=$this->nuevaFecha;
            $procat->ultima_entrega=$numeroEntrega;
            $procat->save();

            //Actualizamos en proyectos
            $this->proyecto->ultima_entrega=$numeroEntrega;
            $this->proyecto->ultima_fecha=$this->nuevaFecha;
            $this->proyecto->save();

             //generar Un Cobro
             $cobro=Cobro::create([
                'proyecto_id'=>$this->proyecto_id,
                'usuario_id'=>$this->usuario_id,
                'categoria_id'=>$this->categoria_id,
                'fecha_corte'=>$this->nuevaFecha,
                'fecha1'=>$this->fecha1,
                'fecha2'=>$this->fecha2,
                'dias'=>$this->dias,
                'estado'=>0
            ]);

             //Guardar Nueva Entrega (Detalles)
             $entregaDetalle=Entrega::create([
                'cotizacion_id'=>$this->proyecto->cotizacion->id,
                'proyecto_id'=>$this->proyecto_id,
                'usuario_id'=>$this->usuario_id,
                'fecha'=>$this->nuevaFecha,
                'codigo'=>$conse->entregas,
                'numero'=>$numeroEntrega,
                'contacto'=>($this->proyecto->cotizacion->contacto),
                'estado'=>0
                ]);

                $pesodia=0;
                $piezas=0;
                $pesototal=0;
                $cantidadtotal=0;
                $pesodiatotal=0;
                $subtotal=0;
                $total=0;
                $iva=0;
                $acum_subtotal=0;
                $acum_iva=0;
                $acum_total=0;

            foreach ($this->matriz as $item) {
                    $item->estado=0;
                    $item->save();
                    $pieza=Pieza::find($item->pieza_id);
                    $peso=$item->pieza->peso;
                    $pesodia=$this->dias * $peso * $item->restante;
                    //Registrar Subcorte
                    $piezas++;
                    $pesototal=$pesototal+$peso;
                    $cantidadtotal=$cantidadtotal+$item->restante;
                    $pesodiatotal=$pesodiatotal+$pesodia;
                     //MATERIAL ENCOFRADO
                    $subtotal=  ($item->restante  * $pieza->precio * $this->dias);
                    $iva=  $subtotal * ($this->porcentaje/100);
                    $total= $subtotal + $iva;
                    $acum_subtotal=$acum_subtotal + $subtotal;
                    $acum_iva=$acum_iva + $iva;
                    $acum_total=$acum_total + $total;
                    $subcobro=Subcobro::create([
                        'pieza_id'=>$item->pieza_id,
                        'proyecto_id'=>$this->proyecto_id,
                        'categoria_id'=>$this->categoria_id,
                        'cobro_id'=>$cobro->id,
                        'numero'=>$conseSubcobros,
                        'cantidad'=>$item->restante,
                        'peso'=>$peso,
                        'dias'=>$this->dias,
                        'fecha1'=>$this->fecha1,
                        'fecha2'=>$this->fecha2,
                        'pesodia'=>$pesodia,
                        'valor'=>$pieza->precio,
                        'subtotal'=>$subtotal,
                        'iva'=>$iva,
                        'total'=>$total
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
                        'categoria_id' =>  ($this->categoria_id),
                        'numero' =>  ($numeroEntrega),
                        'tipo'=>'Generado por cobro',
                        'entregadas' => ($item->restante),
                        'restante' => ($item->restante),
                        'fecha'=>$this->nuevaFecha
                    ]);

            }

               //Actualiar Cobro
               $cobro->piezas=$piezas;
               $cobro->estado=1;
               $cobro->pesototal=$pesototal;
               $cobro->cantidadtotal=$cantidadtotal;
               $cobro->pesodiatotal=$pesodiatotal;
               $cobro->subtotal=$acum_subtotal;
               $cobro->iva=$acum_iva;
               $cobro->total=$acum_total;
               $cobro->save();

             $const=ConsecutivoProyecto::getProyectoId($this->proyecto_id);
             $const->subcobros=$conseSubcobros;
             $const->save();
            DB::commit();
            session()->flash('message', 'COBRO REALIZADO EXITOSAMENTE');
            return redirect()->route('proyectos.opciones', $this->proyecto_id);
         } catch (\Exception $e) {
            DB::rollback();
            session()->flash('advertencia', $e->getMessage());
        }
    }





}
