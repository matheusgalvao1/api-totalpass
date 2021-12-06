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
            $token = $user->createToken("acessToken");
            return response()->json([
                'sucess'=> $sucess,
                'message' => 'Usuario criado com sucesso! ',
                'token' => $token->plainTextToken
            ], 200);
        }else{
            return response()->json([
                'sucess'=> $sucess,
                'message' => 'Falha ao criar usuário'
            ], 400);
        }
    }

    public function addAccount(Request $request){
        $conta = new Conta();
        $validator = Validator::make($request->all(), [
            'nome' => 'required|regex:/^[a-zA-Z ]*$/',
            'login' => 'required',
            'senha' => 'required|min:6'
        ],
        [
            'required' => 'O campo :attribute precisa ser informado!',
            'regex' => 'O campo :attribute inserido não é valido!',
            'min' => 'A senha precisa ter pelo menos 6 elementos!'
        ]);
        if ($validator->fails()){
            return response()->json([
                'sucess'=> false,
                'erros' => $validator->errors()->all(),
            ], 422); 
        }
        $userToken = $request->header("userToken");
        $retorno = Usuario::where("token", $userToken)->get("idusuario");
        if(empty($retorno[0])){
            return response()->json([
                'sucess'=> false,
                'message' => 'Usuário não autorizado',
            ], 401);
        }
        $conta->nome = $request->input("nome");
        $conta->login = $request->input("login");
        $conta->senha = $request->input("senha");
        $conta->idusuario = $retorno[0]["idusuario"];
        $sucess = $conta->save();
        if($sucess){
            return response()->json([
                'sucess'=> true,
                'message' => 'Conta adicionada',
            ], 200);
        }else{
            return response()->json([
                'sucess'=> false,
                'message' => 'Falha!',
            ], 403);
        }
    }

}
