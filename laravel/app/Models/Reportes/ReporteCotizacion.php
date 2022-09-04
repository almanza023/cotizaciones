<?php

namespace App\Models\Reportes;

use App\Models\CargaAcademica;
use App\models\Convivencia;
use App\Models\Cotizacion;
use App\Models\DetalleAndamio;
use App\Models\DetalleCotizacion;
use App\models\DireccionGrado;
use App\Models\LogroDisciplinario;
use App\Models\Nivelacion;
use App\Models\Pieza;
use App\Models\Prefijo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteCotizacion extends Model
{

   public static function reporte($pdf, $cotizacion_id){
    Auxiliar::cabecera($pdf);
    $data=Cotizacion::find($cotizacion_id);
    $pdf->Cell(190, 6, utf8_decode('COTIZACION N° ').$data->numero.'                    '.('           FECHA ').Carbon::parse($data->fecha)->format('d/m/Y'), 1, 1, 'C', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(110, 4, 'Cliente: '.$data->cliente->nombre , 1, 0, 'J');
    $pdf->Cell(80, 4, 'NIT/CC '.$data->cliente->numero , 1, 0, 'J');
    $pdf->Ln();
    $pdf->Cell(110, 5, 'Proyecto: '.$data->proyecto, 1, 0, 'J');
    $pdf->Cell(80, 5, utf8_decode('Teléfono ').$data->telefono , 1, 1, 'J');
    $pdf->Cell(110, 5, utf8_decode('Contacto ').$data->contacto, 1, 0, 'J');
    $pdf->Cell(80, 5, utf8_decode('Email ').$data->correo, 1, 1, 'J');
    $pdf->Cell(63, 5, utf8_decode('Sitio Entrega EN BODEGA '), 1, 0, 'J');
    $pdf->Cell(47, 5, utf8_decode('Forma de Pago ').$data->forma_pago, 1, 0, 'J');
    $pdf->Cell(80, 5, utf8_decode('Vencimiento ').$data->vencimiento, 1, 1, 'J');

    $listadoAndamios=DetalleCotizacion::getAndamios($cotizacion_id, 1);
    $listadoMaterial=DetalleCotizacion::getCotizacion($cotizacion_id, 1, 3);
    $listadoProductos=DetalleCotizacion::getCotizacion($cotizacion_id, 1, 4);
    $listadoServicios=DetalleCotizacion::getCotizacion($cotizacion_id, 1, 5);
    if(count($listadoAndamios)>0){
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(190, 6, utf8_decode('DETALLES DE ANDAMIOS '), 1, 1, 'C', 1);
                $pdf->Cell(110, 6, utf8_decode('NOMBRE'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('CANTIDAD'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('PESO TOTAL'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('VALOR'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('TOTAL'), 1, 1, 'J', 1);
        foreach ($listadoAndamios as $item) {
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(110, 6, utf8_decode($item->andamio->nombre), 1, 0, 'J');
                $pdf->Cell(20, 6, utf8_decode($item->cantidad), 1, 0, 'J');
                $pdf->Cell(20, 6, utf8_decode($item->peso_total), 1, 0, 'J');
                $pdf->Cell(20, 6, number_format($item->andamio->valor), 1, 0, 'J');
                $pdf->Cell(20, 6, number_format($item->total), 1, 1, 'J');
                $detalles=DetalleAndamio::getAndamio($item->andamio_id);
                foreach ($detalles as $item) {
                    $pdf->Cell(110, 6, utf8_decode($item->pieza->nombre), 1, 1, 'J');
                }
                $pdf->Ln(1.5);
        }
    }
   if (count($listadoMaterial)>0) {
    $pdf->Ln(1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(190, 6, utf8_decode('DETALLES DE MATERIAL ENCOFRADO '), 1, 1, 'C', 1);
    $pdf->Cell(110, 6, utf8_decode('DESCRIPCION'), 1, 0, 'J', 1);
            $pdf->Cell(25, 6, utf8_decode('CANTIDAD'), 1, 0, 'J', 1);
            $pdf->Cell(25, 6, utf8_decode('VALOR'), 1, 0, 'J', 1);
            $pdf->Cell(30, 6, utf8_decode('TOTAL'), 1, 1, 'J', 1);
    foreach ($listadoMaterial as $item) {
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(110, 6, utf8_decode($item->pieza->nombre), 1, 0, 'J');
        $pdf->Cell(25, 6, ($item->cantidad), 1, 0, 'J');
        $pdf->Cell(25, 6, number_format($item->precio), 1, 0, 'J');
        $pdf->Cell(30, 6, number_format($item->total), 1, 1, 'J');
    }
   }
    if(count($listadoProductos)>0){
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 6, utf8_decode('DETALLES DE PRODUCTOS'), 1, 1, 'C', 1);
                $pdf->Cell(115, 6, utf8_decode('DESCRIPCION'), 1, 0, 'J', 1);
                $pdf->Cell(25, 6, utf8_decode('CANTIDAD'), 1, 0, 'J', 1);
                $pdf->Cell(25, 6, utf8_decode('VALOR'), 1, 0, 'J', 1);
                $pdf->Cell(25, 6, utf8_decode('TOTAL'), 1, 1, 'J', 1);
        foreach ($listadoProductos as $item) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(115, 6, utf8_decode($item->pieza->nombre), 1, 0, 'J');
            $pdf->Cell(25, 6, ($item->cantidad), 1, 0, 'J');
            $pdf->Cell(25, 6, number_format($item->precio), 1, 0, 'J');
            $pdf->Cell(25, 6, number_format($item->total), 1, 1, 'J');
        }
    }
    if (count($listadoServicios)>0) {
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 6, utf8_decode('DETALLES DE SERVICIOS'), 1, 1, 'C', 1);
        $pdf->Cell(110, 6, utf8_decode('DESCRIPCION'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('CANTIDAD'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('DIAS'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('VALOR'), 1, 0, 'J', 1);
                $pdf->Cell(20, 6, utf8_decode('TOTAL'), 1, 1, 'J', 1);
        foreach ($listadoServicios as $item) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(110, 6, utf8_decode($item->pieza->nombre), 1, 0, 'J');
            $pdf->Cell(20, 6, ($item->cantidad), 1, 0, 'J');
            $pdf->Cell(20, 6, ($item->dias), 1, 0, 'J');
            $pdf->Cell(20, 6, number_format($item->precio), 1, 0, 'J');
            $pdf->Cell(20, 6, number_format($item->total), 1, 1, 'J');
        }
    }
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(110, 6, utf8_decode(''), 0, 0, 'J');
    $pdf->Cell(80, 6, utf8_decode('Subtotal $ ').number_format($data->subtotal+$data->subtotal2), 1, 1, 'J');
    $pdf->Cell(110, 6, utf8_decode(''), 0, 0, 'J');

    $pdf->Cell(80, 6, utf8_decode('Descuento $ 0'), 1, 1, 'J');
    $pdf->Cell(110, 6, utf8_decode(''), 0, 0, 'J');
    $pdf->Cell(80, 6, utf8_decode('IVA $').number_format($data->iva), 1, 1, 'J');
    $pdf->Cell(110, 6, utf8_decode(''), 0, 0, 'J');
    $pdf->Cell(80, 6, utf8_decode('Total $').number_format($data->total), 1, 1, 'J');


    $pdf->Output();
    exit;

   }
}









