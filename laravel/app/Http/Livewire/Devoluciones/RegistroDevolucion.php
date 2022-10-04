<?php

namespace App\Http\Livewire\Devoluciones;

use App\Models\CategoriaProyecto;
use App\Models\Cobro;
use App\Models\Consecutivo;
use App\Models\ConsecutivoProyecto;
use App\Models\DetalleEntrega;
use App\Models\Devolucion;
use App\Models\Empresa;
use App\Models\Entrega;
use App\Models\EntregaProyecto;
use App\Models\Pieza;
use App\Models\Proyecto;
use App\Models\Reposicion;
use App\Models\Subcobro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistroDevolucion extends Component
{

    public $listadoPiezas=[], $proyecto, $usuario, $categoria_id;
    public $proyecto_id, $fecha, $cotizacion_id, $porcentaje;
    public $cantidad1=[], $reposiciones=[], $valores=[],  $fecha_corte, $dias, $total, $reposicion='NO';
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
        $this->porcentaje=Empresa::getPorcentaje();
        $this->total=0;
        $this->categorias=CategoriaProyecto::getCategoriasByProyecto($this->proyecto_id);
        $this->listadoPiezas=EntregaProyecto::getProyecto($this->proyecto_id, $this->categoria_id);
        $cobro=Cobro::ultimoCobro($this->proyecto_id);
        $ent=Entrega::getNumeroEntrega($this->proyecto_id);
        $this->fecha_corte=$ent->fecha;
       if(!empty($this->fecha) && !empty($this->categoria_id)){
        $this->dias=Carbon::createFromDate($this->fecha)->diffInDays(Carbon::createFromDate($this->fecha_corte)) + 1;

        }
        if(!empty($this->categoria_id)){
            $this->total=EntregaProyecto::getTotalPiezas($this->proyecto_id, $this->categoria_id, 1);
        }

       if(count($this->cantidad1)==0){
        foreach ($this->listadoPiezas as $item) {
            array_push($this->cantidad1, [
                "id" => $item->id,
                "pieza_id" => $item->pieza_id,
                "peso" => $item->pieza->peso,
                "entregadas" => $item->entregadas,
                "can" =>"",
                "restante"=>$item->restante,
                "precio"=>$item->pieza->precio,
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

        $i=0;
        $array_reposicion=[];
        foreach ($this->reposiciones as $item) {
            if($item['can']>$this->cantidad1[$i]['can']){
                return session()->flash('advertencia', 'CANTIDAD NO PERMITIDA EN REPOSICION');
            }
            if($this->valores[$i]['can'] < 0){
                return session()->flash('advertencia', 'VALOR NO PERMITIDO');
            }
            $temp_array=[
                'pieza_id'=>$this->cantidad1[$i]['pieza_id'],
                'can'=>$item['can'],
                'valor'=>$this->valores[$i]['can'],
                'subtotal'=>$this->valores[$i]['can'] * $item['can']
            ];
            array_push($array_reposicion, $temp_array);
            $i++;
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
             $acumsubtotal=0;
             $acumiva=0;
             $acumtotal=0;

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
                     $subtotal=$this->dias * $item['precio'] * $item["restante"];
                     $iva=$subtotal * ($this->porcentaje/100);
                     $total=$subtotal + $iva;
                     $acumsubtotal+=$subtotal;
                     $acumiva+=$iva;
                     $acumtotal+=$total;


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
                        'pesodia'=>$pesodia,
                        'valor'=>$item['precio'],
                        'subtotal'=>$subtotal,
                        'iva'=>$iva,
                        'total'=>$total,
                    ]);

                    //Generar Nueva Entrega General
                    EntregaProyecto::create(
                        [
                            'proyecto_id' =>  ($this->proyecto_id),
                            'categoria_id' =>  ($this->categoria_id),
                            'pieza_id' =>  ($item['pieza_id']),
                            'tipo'=>'Generado por devoluciones',
                            'numero' =>  (2),
                            'entregadas' => ($restante),
                            'restante' => ($restante),
                            'fecha'=>$nuevaFecha
                        ]);
                }
                //Cobrar Reposiciones
                $totalReposicion=0;
                if($this->reposicion=='SI'){
                    $i=0;
                    foreach ($array_reposicion as $item) {
                        $subcobro=Subcobro::create([
                            'pieza_id'=>$item['pieza_id'],
                            'proyecto_id'=>$this->proyecto_id,
                            'categoria_id'=>$this->categoria_id,
                            'cobro_id'=>$cobro->id,
                            'numero'=>$conseSubcobros,
                            'cantidad'=>$item["can"],
                            'valor'=>$item["valor"],
                            'reposicion'=>1,
                            'dias'=>$this->dias,
                            'fecha1'=>$this->fecha_corte,
                            'fecha2'=>$this->fecha,
                            'subtotal'=>$item["subtotal"]
                        ]);
                        //Registrar las reposciones que se realizan
                        Reposicion::create([
                            'pieza_id'=>$item['pieza_id'],
                            'proyecto_id'=>$this->proyecto_id,
                            'categoria_id'=>$this->categoria_id,
                            'cantidad'=>$item["can"],
                            'fecha'=>$this->fecha,
                            'valor'=>$item["valor"],
                            'subtotal'=>$item["subtotal"],
                        ]);
                        $totalReposicion=$totalReposicion + $item["subtotal"];
                    }
                }
                //Actualizar subcobro
                $cobro->piezas=$piezas;
                $cobro->pesototal=$pesototal;
                $cobro->cantidadtotal=$cantidadtotal;
                $cobro->pesodiatotal=$pesodiatotal;
                $cobro->subtotal_reposicion=$totalReposicion;
                $cobro->subtotal=$acumsubtotal;
                $cobro->iva=$acumiva;
                $cobro->total=$acumtotal;
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
