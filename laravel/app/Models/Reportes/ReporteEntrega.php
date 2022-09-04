<?php

namespace App\Models\Reportes;



use App\Models\DetalleEntrega;
use App\Models\Entrega;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteEntrega extends Model
{

   public static function reporte($pdf, $id){
    Auxiliar::cabecera($pdf);
    $data=Entrega::find($id);
    $pdf->Cell(190, 6, utf8_decode('REMISIÓN'),1, 1, 'C', 1);
    $pdf->Cell(190, 6, utf8_decode('ENTREGA N° ').$data->codigo.'                    '.('           FECHA ').Carbon::parse($data->fecha)->format('d/m/Y'), 1, 1, 'C', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(190, 6, 'Contacto: '.$data->contacto , 1, 0, 'J');
    $pdf->Ln();


    $detalles=DetalleEntrega::getEntrega($id);
    if(count($detalles)>0){
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(190, 6, utf8_decode('DETALLES DE ENTREGA '), 1, 1, 'C', 1);
                $pdf->Cell(140, 6, utf8_decode('NOMBRE'), 1, 0, 'J', 1);
                $pdf->Cell(50, 6, utf8_decode('CANTIDAD'), 1, 1, 'J', 1);
        foreach ($detalles as $item) {
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(140, 6, utf8_decode($item->pieza->nombre), 1, 0, 'J');
                $pdf->Cell(50, 6, utf8_decode($item->cantidad), 1, 1, 'J');

        }
    }



    $pdf->Output();
    exit;

   }
}









