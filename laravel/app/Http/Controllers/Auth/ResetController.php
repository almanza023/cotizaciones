<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Mail\EmailPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetController extends Controller
{
    public function index(){
        return view('auth.reset');
    }

    public function resetPassword(Request $request){


        $this->validar($request);
        $user=User::validarUsuario($request->correo, $request->documento);
        if($user){
            $psswd = substr( md5(microtime()), 1, 8);
            $user->password_reset=($psswd);
            $user->password=Hash::make($psswd);
            $user->verify_password=1;
            $user->save();
            Mail::to($user->email)->send(new EmailPassword($user));
            return redirect()->route('reset')->with(['success'=>'Se ha restablecido la contraseña exitosamente. Revise su correo electronico']);





        }else{
            return redirect()->route('reset')->withErrors(['usuario'=>'Estas credenciales no coinciden con nuestros registros']);
        }




     }



     protected function validar(Request $request){

        $rules = [
            'correo' => 'required|email',
            'documento' => 'required'
        ];

        $customMessages = [
            'required' => 'El :attribute campo es requerido.'
        ];
        $this->validate($request, $rules, $customMessages);

    }


}
