<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Cripto;
use Illuminate\Http\Request;

class AdicionarController extends Controller
{
    private function validateUserInputs($user, &$message){
        if ((!preg_match("/^[a-zA-Z ]*$/", $user->nome) || $user->nome == '') || $user->nome == ' '){
            $message = 'Nome inválido!';
            return false;
        }
        if (!preg_match("/^[a-zA-Z]*$/", $user->sobrenome) || $user->sobrenome == ''){
            $message = 'Sobrenome inválido!';
            return false;
        }
        if ($user->senha == '' || $user->senha == ' '){
            $message = 'Uma senha precisa ser informada!';
            return false;
        }
    }

    public function addUser(Request $request){
        $user = new Usuario();
        $crypt = new Cripto();
        $sucess = true;
        $message = '';
        $user->nome = $request->input('nome');
        $user->sobrenome = $request->input('sobrenome');
        $user->email = $request->input('email');
        $user->senha = $request->input('senha');
        //$sucess = $this->validateUserInputs($user, $message);
        if ($sucess){
            $user->nome = $crypt->encrypt($user->nome);
            $user->sobrenome = $crypt->encrypt($user->sobrenome);
            $user->email = $crypt->encrypt($user->email);
            $user->senha = $crypt->encrypt($user->senha);
            $sucess = $user->save();
            if ($sucess)
                $message = 'Usuario criado com sucesso!';
        }
        return response()->json([
            'sucess'=> $sucess,
            'message' => $message
        ], 200);
    }

}
