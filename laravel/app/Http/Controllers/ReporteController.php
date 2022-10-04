<?php

namespace App\Http\Controllers;

use App\Models\Reportes\ReporteCotizacion;
use App\Models\Reportes\ReporteEntrega;
use App\Models\Reportes\ReporteFactura;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function reporteCotizacion($id)
    {
        $pdf = app('Fpdf');
        ReporteCotizacion::reporte($pdf, $id );

    }

    public function reporteEntrega($id)
    {
        $pdf = app('Fpdf');
        ReporteEntrega::reporte($pdf, $id );

    }
    public function imprimirFactura($id)
    {
        $pdf = app('Fpdf');
        ReporteFactura::reporte($pdf, $id );

    }

    public function rangoFacturas(Request $request)
    {
        $pdf = app('Fpdf');
        //ReporteFactura::reporte($pdf, $id );

    }




}
