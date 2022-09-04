<?php

namespace App\Models\Reportes;

use App\Models\CargaAcademica;
use App\models\Convivencia;
use App\models\DireccionGrado;
use App\Models\Grado;
use App\Models\LogroDisciplinario;
use App\Models\Nivelacion;
use App\Models\Prefijo;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auxiliar extends Model
{



    public static function cabecera($pdf){
        $nombre="GRUPO HE SAS";
        $path=public_path().'/logo.png';
        //$path2=public_path().'/bandera.jpg';

        $pdf->AddPage();
        $pdf->SetFillColor(232, 232, 232);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 6, utf8_decode($nombre), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Image($path, 8, 6, 20);
        //$pdf->Image($path2, 180, 8, 20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(8);

     }


}
