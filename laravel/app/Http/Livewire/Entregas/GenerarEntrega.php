<?php

namespace App\Http\Livewire\Entregas;

use App\Models\Categoria;
use App\Models\CategoriaProyecto;
use App\Models\Cobro;
use App\Models\CobroEncofrado;
use App\Models\Consecutivo;
use App\Models\ConsecutivoProyecto;
use App\Models\DetalleEntrega;
use App\Models\Entrega;
use App\Models\EntregaProyecto;
use App\Models\Pieza;
use App\Models\Proyecto;
use App\Models\Subcobro;
use App\Models\SubcobroEncofrado;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GenerarEntrega extends Component
{

    public $proyecto_id, $cotizacion_id, $usuario, $fechaUtlima, $detallesUltimaEntrega,
     $obj, $data, $porcentaje,
    $categoria_id, $categorias, $cantidad, $fecha, $nombre_proyecto;
    public $registrado=false, $detalles, $proyecto, $dias, $valor_total, $valor_subtotal, $valor_iva, $canpiezas;

    public $entrega_id, $contacto, $descripcion, $total;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function mount($id)
    {
        $this->proyecto_id = $id;
    }

    public function render()
    {
        $this->usuario=auth()->user()->id;
        $this->cantidad='';
        $this->porcentaje=19;
        $this->proyecto=Proyecto::find($this->proyecto_id);
        if(empty($this->proyecto)){

        }
        $this->contacto=$this->proyecto->cotizacion->contacto;


       if(empty($this->numero)){
        $this->numero=ConsecutivoProyecto::getProyecto($this->proyecto_id)+1;
       }
        //$this->fecha=Carbon::now()->format('Y-m-d');
        $piezas=[];
        $this->fechaUtlima='';
        $this->categorias=CategoriaProyecto::getCategoriasByProyecto($this->proyecto_id);
        if(!empty($this->categoria_id)){
            $piezas=Pieza::search($this->search, $this->categoria_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);
            $this->detallesUltimaEntrega=CategoriaProyecto::getUltimoRegistrado($this->proyecto_id, $this->categoria_id);
            if(!empty($this->detallesUltimaEntrega)){
                $this->fechaUtlima=$this->detallesUltimaEntrega->ultima_fecha ;

            }else{
                $this->fechaUtlima='No Existe Fecha';
            }
        }
        if(!empty($this->fecha) && !empty($this->categoria_id)){
            $this->dias=Carbon::createFromDate($this->fecha)->diffInDays(Carbon::createFromDate($this->fechaUtlima)) + 1;
        }

        return view('livewire.entregas.generar-entrega', compact('piezas'));
    }

    public function add($id){
        $validated = $this->validate([
            'cantidad' => 'required',
        ]);
        $pieza=Pieza::find($id);
        if($this->cantidad > $pieza->cantidad){
            return session()
            ->flash('advertencia', 'LA CANTIDAD INGRESADA EN '.$pieza->nombre.' SUPERA AL STOCK');
        }
        if(!empty($pieza)){
            $det=DetalleEntrega::updateOrCreate(
                [
                    'entrega_id' =>  ($this->entrega_id),
                    'pieza_id' =>  ($id),
                ],
                [
                    'entrega_id' =>  ($this->entrega_id),
                    'pieza_id' =>  ($id),
                    'cantidad' => ($this->cantidad),
                    'fecha_entrega' => ($this->fecha),
                    'precio' => ($pieza->precio),
                    'estado'=>0
                ]);
            $this->detalles=DetalleEntrega::getEntrega($this->entrega_id);
            $this->cantidad='';
            $this->canpiezas=DetalleEntrega::getCantidadPiezas($this->entrega_id);
        }else{
            session()->flash('advertencia', 'PIEZA NO EXISTE');
        }
    }

    public function quitar($id){
        $det=DetalleEntrega::find($id);
        $pieza_id=$det->pieza_id;
        $det->delete();
        $entrega=EntregaProyecto::eliminar($pieza_id, $this->proyecto_id, $this->numero);
        if(!empty($entrega)){
            $entrega->delete();

        }
        $this->detalles=DetalleEntrega::getEntrega($this->entrega_id);
        $this->canpiezas=DetalleEntrega::getCantidadPiezas($this->entrega_id);
    }

    public function store(){
        if(empty($this->categoria_id)){
            return session()->flash('advertencia', 'DEBE SELECCIONAR UNA CATEGORIA');
        }
        $validated = $this->validate([
            'contacto' => 'required',
            'fecha' => 'required|date'
        ]);
        if($this->fecha < $this->proyecto->ultima_fecha){
            return session()->flash('advertencia', 'FECHA NO ES PERMITIDA');
        }
        //aUMENTAR cONSECUTIVOS DE ENTREGAS DEL SISTEMA
        $cons=Consecutivo::getActive();
        $cod=$cons->entregas+1;
        $cons->entregas=$cod;
        $cons->save();


        $this->obj=Entrega::create([
                    'cotizacion_id' => ($this->proyecto->cotizacion_id),
                    'proyecto_id' => ($this->proyecto_id),
                    'categoria_id' => ($this->categoria_id),
                    'codigo' => ($cons->entregas),
                    'contacto' => ($this->contacto),
                    'numero' => ($this->numero),
                    'descripcion' => ($this->descripcion),
                    'fecha' =>  ($this->fecha),
                    'estado'=>0,
                    'usuario_id'=>(auth()->user()->id)
        ]);
        $this->entrega_id=$this->obj->id;
        $this->registrado=true;
    }



    public function finalizar(){
        DB::beginTransaction();
        try {
        $const=ConsecutivoProyecto::getProyectoId($this->proyecto_id);
        $const->numero=$this->numero;
        $const->save();
        $conseSubcobros=ConsecutivoProyecto::getSubcobros($this->proyecto_id)+1;
        $nuevaFecha=Carbon::createFromDate($this->fecha)->addDay()->format('Y-m-d');

        //Actualizar Proyecto CATEGORIA
        $procat=CategoriaProyecto::getId($this->proyecto_id, $this->categoria_id);
        $procat->ultima_fecha=$nuevaFecha;
        $procat->ultima_entrega=$this->numero;
        $procat->save();

        //Actualizar en Proyectos
        $this->proyecto->ultima_entrega=$this->numero;
        $this->proyecto->ultima_fecha=$nuevaFecha;
        $this->proyecto->save();

        //Se genera un cobro
            $cobro=Cobro::create([
                'proyecto_id'=>$this->proyecto_id,
                'categoria_id'=>$this->categoria_id,
                'usuario_id'=>$this->usuario,
                'fecha_corte'=>$nuevaFecha,
                'fecha1'=>$this->fechaUtlima,
                'fecha2'=>$this->fecha,
                'dias'=>$this->dias,
                'estado'=>0,
            ]);


        //Obtener las piezas en terreno por categorias
        $this->data=EntregaProyecto::getProyecto($this->proyecto_id, $this->categoria_id);
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
        foreach ($this->data as $item) {
                $pieza=Pieza::find($item->pieza_id);
                $peso=$item->pieza->peso;
                $pesodia= ($item->restante * $item->pieza->peso  * $this->dias);
                //Registrar Subcorte
                $piezas++;
                $pesototal=$pesototal+$peso;
                $cantidadtotal=$cantidadtotal+$item->restante;
                $pesodiatotal=$pesodiatotal+$pesodia;
                $subtotal=  ($item->restante  * $pieza->precio * $this->dias) ;
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
                    'valor'=>$pieza->precio,
                    'subtotal'=>$subtotal,
                    'peso'=>$peso,
                    'dias'=>$this->dias,
                    'fecha1'=>$this->fechaUtlima,
                    'fecha2'=>$this->fecha,
                    'pesodia'=>$pesodia,
                    'iva'=>$iva,
                    'total'=>$total
                ]);
            $item->estado=0;
            $item->save();
            //Se Agrega el item nuevamente
            $nueva=EntregaProyecto::registrarEntrega($item, $nuevaFecha, $this->numero);
        }
        //Actualiar Cobro en Terreno
        $cobro->piezas=$piezas;
        $cobro->estado=1;
        $cobro->pesototal=$pesototal;
        $cobro->cantidadtotal=$cantidadtotal;
        $cobro->pesodiatotal=$pesodiatotal;
        $cobro->subtotal=$acum_subtotal;
        $cobro->iva=$acum_iva;
        $cobro->total=$acum_total;
        $cobro->save();

        //Se genera un cobro de la nueva entrega
        $cobro2=Cobro::create([
            'proyecto_id'=>$this->proyecto_id,
            'categoria_id'=>$this->categoria_id,
            'usuario_id'=>$this->usuario,
            'fecha_corte'=>$nuevaFecha,
            'fecha1'=>$this->fecha,
            'fecha2'=>$this->fecha,
            'dias'=>1,
            'estado'=>0,
        ]);

        //Reiniciar Contadores
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

        //Registrar nuevas piezas y actualizar existentes
        foreach ($this->detalles as $item) {

                $pieza=Pieza::find($item->pieza_id);

                $peso=$pieza->peso;
                $pesodia= ($item->cantidad * $peso  * 1);
                //Registrar Subcorte
                $piezas++;
                $pesototal=$pesototal+$peso;
                $cantidadtotal=$cantidadtotal+$item->cantidad;
                $pesodiatotal=$pesodiatotal+$pesodia;

                $subtotal=  ($item->cantidad  * $pieza->precio * 1) ;
                $iva=  $subtotal * ($this->porcentaje/100);
                $total= $subtotal + $iva;
                $acum_subtotal=$acum_subtotal + $subtotal;
                $acum_iva=$acum_iva + $iva;
                $acum_total=$acum_total + $total;

                $subcobro2=Subcobro::create([
                    'pieza_id'=>$item->pieza_id,
                    'proyecto_id'=>$this->proyecto_id,
                    'categoria_id'=>$this->categoria_id,
                    'cobro_id'=>$cobro2->id,
                    'numero'=>$conseSubcobros,
                    'cantidad'=>$item->cantidad,
                    'valor'=>$pieza->precio,
                    'subtotal'=>$subtotal,
                    'peso'=>$peso,
                    'dias'=>1,
                    'fecha1'=>$this->fecha,
                    'fecha2'=>$this->fecha,
                    'pesodia'=>$pesodia,
                    'iva'=>$iva,
                    'total'=>$total
                ]);
            $entrega=EntregaProyecto::registar($this->proyecto_id, $item->pieza_id, $this->numero, 'Genereado por Entrega', $item->cantidad, $nuevaFecha);
            Pieza::decrementar($item->pieza_id, $item->cantidad, $nuevaFecha);
            $item->estado=1;
            $item->save();
         }
            //Actualiar Cobro en Terreno
            $cobro2->piezas=$piezas;
            $cobro2->estado=1;
            $cobro2->pesototal=$pesototal;
            $cobro2->cantidadtotal=$cantidadtotal;
            $cobro2->pesodiatotal=$pesodiatotal;
            $cobro2->subtotal=$acum_subtotal;
            $cobro2->iva=$acum_iva;
            $cobro2->total=$acum_total;
            $cobro2->save();
            //Actualizar consecutivo proyecto
            $const=ConsecutivoProyecto::getProyectoId($this->proyecto_id);
            $const->subcobros=$conseSubcobros;
            $const->save();

         //Actualizar Estado Entrega
         $this->obj->estado=1;
         $this->obj->save();
         DB::commit();
         session()->flash('message', 'ENTREGA FINALIZADA EXITOSAMENTE');

         return redirect()->route('proyectos.opciones', $this->proyecto_id);
      } catch (\Exception $e) {
         DB::rollback();
         session()->flash('advertencia', $e->getMessage());
     }
    }






}
