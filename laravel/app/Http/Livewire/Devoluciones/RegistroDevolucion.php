<?php

namespace App\Http\Livewire\Devoluciones;

use App\Models\CategoriaProyecto;
use App\Models\Cobro;
use App\Models\Consecutivo;
use App\Models\ConsecutivoProyecto;
use App\Models\DetalleEntrega;
use App\Models\Devolucion;
use App\Models\Entrega;
use App\Models\EntregaProyecto;
use App\Models\Pieza;
use App\Models\Proyecto;
use App\Models\Subcobro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistroDevolucion extends Component
{

    public $listadoPiezas=[], $proyecto, $usuario, $categoria_id;
    public $proyecto_id, $fecha, $cotizacion_id;
    public $cantidad1=[], $fecha_corte, $dias;
    public function mount($id)
    {
        $this->proyecto_id = $id;
        $this->proyecto=Proyecto::find($this->proyecto_id);
        $this->cotizacion_id=$this->proyecto->cotizacion_id;

     //$cot=Entrega::find($this->proyecto_id);
        if(!empty($cot)){
            if($cot->estado==1 || $cot->estado==2){
                //session()->flash('message', 'LA COTIZACION YA SE ENCUENTRA CERRADA');
                //return redirect()->route('cotizaciones');
            }
        }else{
            //session()->flash('message', 'NO EXISTE CODIGO');
            //return redirect()->route('cotizaciones');
        }
    }

    public function render()
    {
        $this->usuario=auth()->user()->id;
        $this->total=0;
        $this->categorias=CategoriaProyecto::getCategoriasByProyecto($this->proyecto_id);
        $this->listadoPiezas=EntregaProyecto::getProyecto($this->proyecto_id, $this->categoria_id);
        $cobro=Cobro::ultimoCobro($this->proyecto_id);
        $ent=Entrega::getNumeroEntrega($this->proyecto_id);
        $this->fecha_corte=$ent->fecha;
       if(!empty($this->fecha) && !empty($this->categoria_id)){
        $this->dias=Carbon::createFromDate($this->fecha)->diffInDays(Carbon::createFromDate($this->fecha_corte)) + 1;
       }

       if(count($this->cantidad1)==0){
        foreach ($this->listadoPiezas as $item) {
            array_push($this->cantidad1, [
                "id" => $item->id,
                "pieza_id" => $item->pieza_id,
                "peso" => $item->pieza->peso,
                "entregadas" => $item->entregadas,
                "can" =>"",
                "restante"=>$item->restante
            ]);
        }
       }
        return view('livewire.devoluciones.registro-devolucion');
    }

    public function store() {
        //dd($this->cantidad1);
        $validated = $this->validate([
            'fecha' => 'required|date',
            'categoria_id' => 'required',

        ]);
        //Validar que la fecha de la devolucion sea mayor a la fecha del corte
        if($this->fecha < $this->fecha_corte){
            return session()->flash('advertencia', 'FECHA DEVOLUCION NO ES VALIDA');
        }

           //dd($this->cantidad1);
           $date=Carbon::now()->format('Y-m-d');
           $nuevaFecha=Carbon::createFromDate($this->fecha)->addDay()->format('Y-m-d');




           if(count($this->cantidad1)>0){
            DB::beginTransaction();
            try {
            $conse=Consecutivo::aumentarConsEntregas();
            $conseSubcobros=ConsecutivoProyecto::getSubcobros($this->proyecto_id)+1;
            $numeroEntrega=Entrega::aumentaNumeroEntrega($this->proyecto_id);

             //Actualizar Proyecto CATEGORIA
             $procat=CategoriaProyecto::getId($this->proyecto_id, $this->categoria_id);
             $procat->ultima_fecha=$nuevaFecha;
             $procat->ultima_entrega=$numeroEntrega;
             $procat->save();

           //generar Un Cobro
            $cobro=Cobro::create([
                'proyecto_id'=>$this->proyecto_id,
                'categoria_id'=>$this->categoria_id,
                'usuario_id'=>$this->usuario,
                'fecha_corte'=>$nuevaFecha,
                'fecha1'=>$this->fecha_corte,
                'fecha2'=>$this->fecha,
                'dias'=>$this->dias,
            ]);
            //Guardar Nueva Entrega (Detalles)
            $entregaDetalle=Entrega::create([
             'cotizacion_id'=>$this->cotizacion_id,
             'proyecto_id'=>$this->proyecto_id,
             'categoria_id'=>$this->categoria_id,
             'usuario_id'=>$this->usuario,
             'fecha'=>$nuevaFecha,
             'codigo'=>$conse->entregas,
             'numero'=>$numeroEntrega,
             'contacto'=>($this->proyecto->cotizacion->contacto)
             ]);
             $piezas=0;
             $pesototal=0;
             $cantidadtotal=0;
             $pesodiatotal=0;

                foreach ($this->cantidad1 as $item) {
                    if(!empty($item["can"])){
                            $cantidad=$item["can"];
                            $det=EntregaProyecto::find($item["id"]);
                            if(empty($det->restante)){
                                if($cantidad > $det->cantidad){
                                    return session()->flash('advertencia', 'CANTIDAD NO PERMITIDA '.$det->pieza->nombre);
                                }
                                $restante=$det->cantidad - $cantidad;
                                $det->devueltas=$cantidad;

                            }else{
                                if($cantidad > $det->restante){
                                    return session()->flash('advertencia', 'CANTIDAD NO PERMITIDA '.$det->pieza->nombre);
                                }
                                $restante=$det->restante - $cantidad;
                                $det->devueltas=$det->devueltas + $cantidad;
                            }
                            $det->restante=$restante;
                            $det->fecha_devolucion=$date;
                            $det->Save();

                            $dev=Devolucion::create(
                                [
                                    'proyecto_id' =>  ($this->proyecto_id),
                                    'categoria_id' =>  ($this->categoria_id),
                                    'pieza_id' =>  ($item["pieza_id"]),
                                    'cantidad' => ($cantidad),
                                    'fecha' => ($this->fecha),
                                ]);

                                $pieza=Pieza::find($item['pieza_id']);
                                $pieza->cantidad= $pieza->cantidad +  $item['can'];
                                $pieza->save();


                    }else{
                        $restante=$item["restante"];
                    }

                    //Guardar detalles de nueva entrega
                    $det=DetalleEntrega::create([
                        'entrega_id'=>$entregaDetalle->id,
                        'pieza_id'=>$item['pieza_id'],
                        'cantidad'=>$item["restante"] - floatval($item["can"]),
                        'fecha_entrega'=>$nuevaFecha,
                     ]);

                     //Actualizar el estado de entregado a Corte Generado
                     $entrega=EntregaProyecto::find($item['id']);
                     $entrega->estado=0;
                     $entrega->save();
                     $pesodia=$this->dias * $item['peso'] * $item["restante"];
                    //Registrar Subcorte
                     $piezas++;
                     $pesototal=$pesototal+$item['peso'];
                     $cantidadtotal=$cantidadtotal+$item['restante'];
                     $pesodiatotal=$pesodiatotal+$pesodia;

                    $subcobro=Subcobro::create([
                        'pieza_id'=>$item['pieza_id'],
                        'proyecto_id'=>$this->proyecto_id,
                        'categoria_id'=>$this->categoria_id,
                        'cobro_id'=>$cobro->id,
                        'numero'=>$conseSubcobros,
                        'cantidad'=>$item["restante"],
                        'peso'=>$item['peso'],
                        'dias'=>$this->dias,
                        'fecha1'=>$this->fecha_corte,
                        'fecha2'=>$this->fecha,
                        'pesodia'=>$pesodia
                    ]);

                    //Generar Nueva Entrega General
                    EntregaProyecto::create(
                        [
                            'proyecto_id' =>  ($this->proyecto_id),
                            'categoria_id' =>  ($this->proyecto_id),
                            'pieza_id' =>  ($item['pieza_id']),
                            'tipo'=>'Generado por devoluciones',
                            'numero' =>  (2),
                            'entregadas' => ($restante),
                            'restante' => ($restante),
                            'fecha'=>$nuevaFecha
                        ]);
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
            session()->flash('message', 'DEVOLUCION FINALIZADA EXITOSAMENTE');
            return redirect()->route('proyectos.opciones', $this->proyecto_id);
         } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message', $e->getMessage());
        }
    }


    }


}
