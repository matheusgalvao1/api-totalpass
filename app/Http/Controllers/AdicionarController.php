<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Usuario;
use Illuminate\Http\Request;

class Cripto{
    function encrypt($mensagem){
        $chave = "16428adnsadk123";
        $iv = "wNYtCnelXfOa6uiJ";
        $resultado = openssl_encrypt($mensagem, "AES-256-CBC", $chave, OPENSSL_RAW_DATA, $iv);
        $resultado = base64_encode($resultado);
        return $resultado;
    }

    function decrypt($mensagem){
        $chave = "16428adnsadk123";
        $iv = "wNYtCnelXfOa6uiJ";
        $resultado = base64_decode($mensagem);
        $resultado = openssl_decrypt($resultado, "AES-256-CBC", $chave, OPENSSL_RAW_DATA, $iv);
        return $resultado;
    }
}

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
            $user->senha = password_hash($user->senha, PASSWORD_DEFAULT);
            $sucess = $user->save();
            if ($sucess){
                $message = 'Usuario criado com sucesso!';
                return response()->json([
                    'sucess'=> $sucess,
                    'message' => $message
                ], 200);
            }else{
                return response()->json([
                    'sucess'=> $sucess,
                    'message' => $message
                ], 400);
            }
        }
    }

    public function addAccount(Request $request){
        $usertoken = $request->header("userToken");
        $conta = new Conta();
        $nome = $request->input("nome");
        $login = $request->input("login");
        $senha = $request->input("senha");


    }

}
