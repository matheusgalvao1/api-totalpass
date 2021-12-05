<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function addUser(Request $request){
        $user = new Usuario();
        $crypt = new Cripto();
        $validator = Validator::make($request->all(), [
            'nome' => 'required|regex:/^[a-zA-Z ]*$/',
            'sobrenome' => 'required|regex:/^[a-zA-Z ]*$/',
            'email' => 'email|required|unique:App\Models\Usuario,email',
            'senha' => 'required|min:6'
        ],
        [
            'required' => 'O campo :attribute precisa ser informado!',
            'regex' => 'O campo :attribute inserido não é valido!',
            'email' => 'O email inserido não está no formato correto',
            'unique' => 'O email inserido já está em uso!',
            'min' => 'A senha precisa ter pelo menos 6 elementos!'
        ]);
        if ($validator->fails()){
            return response()->json([
                'sucess'=> false,
                'erros' => $validator->errors()->all(),
            ], 422); 
        }
        $user->nome = $crypt->encrypt($user->nome);
        $user->sobrenome = $crypt->encrypt($user->sobrenome);
        $user->email = $request->input("email");
        $user->senha = password_hash($user->senha, PASSWORD_DEFAULT);
        $sucess = $user->save();
        if ($sucess){
            return response()->json([
                'sucess'=> $sucess,
                'message' => 'Usuario criado com sucesso!'
            ], 200);
        }else{
            return response()->json([
                'sucess'=> $sucess,
                'message' => 'Falha ao criar usuário'
            ], 400);
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
