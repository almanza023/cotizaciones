<?php

namespace App\Http\Livewire\Empresa;

use App\Models\Empresa;
use Livewire\Component;

class RegistroEmpresa extends Component
{
    public $data, $nombre, $nit, $correo, $telefono, $direccion, $porcentaje_iva;
    public function render()
    {
        $this->data=Empresa::find(1);
        $this->nombre=$this->data->nombre;
        $this->nit=$this->data->nit;
        $this->correo=$this->data->correo;
        $this->telefono=$this->data->telefono;
        $this->direccion=$this->data->direccion;
        $this->porcentaje_iva=$this->data->porcentaje_iva;
        return view('livewire.empresa.registro-empresa');
    }

    public function store(){

        $validated = $this->validate([
            'nombre' => 'required',
            'porcentaje_iva' => 'required',
        ]);

        $this->data->nombre=$this->nombre;
        $this->data->nit=$this->nit;
        $this->data->correo=$this->correo;
        $this->data->telefono=$this->telefono;
        $this->data->direccion=$this->direccion;
        $this->data->porcentaje_iva=$this->porcentaje_iva;
        $this->data->save();
        session()->flash('message', 'DATOS ACTUALIZADOS EXITOSAMENTE');
        return redirect()->route('empresa');
    }
}
