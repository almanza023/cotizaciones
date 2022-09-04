<?php

namespace App\Http\Livewire\Home;

use App\Models\Huella;
use App\Models\Profesional;
use App\Models\ProfesionalUnidad;
use Livewire\Component;

class Home extends Component
{
    public $profesional,  $profesionales, $familiasProfesionales=[];
    public function render()
    {
        $doc=auth()->user()->documento;
        $nombre=auth()->user()->name;
        $rol=auth()->user()->rol;
        return view('livewire.home.home');
    }
}
