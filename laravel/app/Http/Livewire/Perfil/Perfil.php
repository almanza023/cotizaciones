<?php

namespace App\Http\Livewire\Perfil;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Perfil extends Component
{
    public $clave1, $clave2;
    public $updateMode = false;

    public function render()
    {

        return view('livewire.perfil.perfil');
    }

    public function update(){
        $validatedDate = $this->validate([
            'clave1' => 'required|min:5',
            'clave2' => 'required|min:5',
        ]);
        if($this->clave1!=$this->clave2){
            return  session()->flash('advertencia', 'LAS CONTRASEÑAS NO COINCIDEN');
        }else{
            $clave=Hash::make($this->clave1);
            $id=auth()->user()->id;
            DB::update('update users set password=? where id = ?',
            [$clave, $id]);
            session()->flash('message', 'INFORMACION ACTUALIZADA EXITOSAMENTE.');
            $this->clave1='';
            $this->clave2='';

        }





    }


}
