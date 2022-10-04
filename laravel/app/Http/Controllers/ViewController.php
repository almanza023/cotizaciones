<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Huella;
use App\Models\ProfesionalUnidad;
use App\Models\Unidad;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categorias()
    {
        return view('categorias.index');
    }

    public function piezas()
    {
        return view('piezas.index');
    }


    public function clientes()
    {
        return view('clientes.index');
    }

    public function andamios()
    {
        return view('andamios.index');
    }

    public function createAndamios()
    {
        return view('andamios.create');
    }


    public function cotizaciones()
    {
        return view('cotizaciones.index');
    }

    public function detallesCotizaciones($id)
    {
        return view('cotizaciones.detalles', compact('id'));
    }

    public function verCotizacion($id)
    {
        return view('cotizaciones.ver', compact('id'));
    }

    public function listadoCotizaciones()
    {
        return view('cotizaciones.listado');
    }

    public function perfil()
    {
        return view('perfil.index');
    }

    public function entregas($id)
    {
        return view('entregas.index', compact('id'));
    }

    public function registroEntrega($id)
    {
        return view('entregas.registro', compact('id'));
    }

    public function verEntrega($id)
    {
        return view('entregas.ver', compact('id'));
    }

    public function usuarios()
    {
        return view('usuarios.index');
    }



    public function devoluciones()
    {
        return view('devoluciones.index');
    }

    public function registroDevolucion($id)
    {
        return view('devoluciones.registro', compact('id'));
    }

    public function verDevolucion($id)
    {
        return view('devoluciones.ver', compact('id'));
    }


    public function serviciosProyectos($id)
    {
        return view('entregas.entregas-servicios', compact('id'));
    }

    public function generarEntrega($id)
    {
        return view('entregas.generar-entrega', compact('id'));
    }

    public function generarEntregaEncofrado($id)
    {
        return view('entregas.generar-entrega-encofrado', compact('id'));
    }


    public function proyectos()
    {
        return view('proyectos.index');
    }

    public function registroCobros($id)
    {
        return view('cobros.registro', compact('id'));
    }

    public function verCobros($id)
    {
        return view('proyectos.ver-cobros', compact('id'));
    }

    public function verEntregaproyecto($id)
    {
        return view('proyectos.ver-entrega', compact('id'));
    }

    public function opcionesProyecto($id)
    {
        return view('proyectos.opciones', compact('id'));
    }

    public function generarFactura($id)
    {
        return view('facturas.generar', compact('id'));
    }


    public function cobrosEncofrados($id)
    {
        return view('cobros_encofrados.registro', compact('id'));
    }

    public function soportes($id)
    {
        return view('soportes.index', compact('id'));
    }

    public function liquidaciones()
    {
        return view('liquidaciones.index');
    }

    public function registroLiquidacion($id)
    {
        return view('liquidaciones.registro', compact('id'));
    }

    public function verLiquidacion($id)
    {
        return view('liquidaciones.ver', compact('id'));
    }

    public function empresa()
    {
        return view('empresa.index');
    }

    public function reportes()
    {
        $categorias=Categoria::getActive();
        return view('reportes.index', compact('categorias'));
    }









}
