<?php

namespace App\Models\Reportes;

use App\Models\Cobro;
use App\Models\DetalleEntrega;
use App\Models\Entrega;
use App\Models\Factura;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteFactura extends Model
{

   public static function reporte($pdf, $id){
    Auxiliar::cabecera($pdf);
    $data=Factura::find($id);
    $pdf->Cell(190, 6, utf8_decode('FACTURA'),1, 1, 'C', 1);
    $pdf->Cell(190, 6, utf8_decode('FACTURA N° ').'                    '.('           FECHA '), 1, 1, 'C', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(190, 6, 'Contacto: ' , 1, 0, 'J');
    $pdf->Ln();
    $detalles=Cobro::getFactura($id);

    if(count($detalles)>0){
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(190, 6, utf8_decode('DETALLES DE ENTREGA '), 1, 1, 'C', 1);
                $pdf->Cell(30, 6, utf8_decode('FECHA INICAL'), 1, 0, 'J', 1);
                $pdf->Cell(30, 6, utf8_decode('FECHA FINAL'), 1, 0, 'J', 1);
                $pdf->Cell(35, 6, utf8_decode('CANTIDAD DE PIEZAS'), 1, 0, 'J', 1);
                $pdf->Cell(25, 6, utf8_decode('N° DIAS'), 1, 0, 'J', 1);
                $pdf->Cell(35, 6, utf8_decode('TOTAL PESO KG'), 1, 0, 'J', 1);
                $pdf->Cell(35, 6, utf8_decode('VALOR KG'), 1, 1, 'J', 1);
        foreach ($detalles as $item) {
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(30, 6, ($item->fecha1), 1, 0, 'J');
                $pdf->Cell(30, 6, ($item->fecha2), 1, 0, 'J');
                $pdf->Cell(35, 6, ($item->cantidadtotal), 1, 0, 'J');
                $pdf->Cell(25, 6, ($item->dias), 1, 0, 'J');
                $pdf->Cell(35, 6, ($item->pesodiatotal), 1, 0, 'J');
                $pdf->Cell(35, 6, ($item->factura->valor_kg), 1, 1, 'J');

        }
        $pdf->Ln();
        $pdf->Cell(30, 6, utf8_decode('SUBTOTAL   ').$data->subtotal, 1, 1, 'C', 1);
        $pdf->Cell(30, 6, utf8_decode('IVA  ').$data->iva, 1, 1, 'J', 1);
        $pdf->Cell(30, 6, utf8_decode('TOTAL  ').$data->total, 1, 0, 'J', 1);
    }



    $pdf->Output();
    exit;

   }
}









