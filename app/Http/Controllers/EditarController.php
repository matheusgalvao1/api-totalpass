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

class EditarController extends Controller
{
    public function editUser(Request $request){
        $userToken = $request->header("userToken");
        $retorno = Usuario::where("token", $userToken)->first("idusuario");
        $user = Usuario::find($retorno['idusuario']);
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
                'message' => 'Usuario editado com sucesso! ',
            ], 200);
        }else{
            return response()->json([
                'sucess'=> $sucess,
                'message' => 'Falha ao criar usuário'
            ], 400);
        }
    }

    public function editAccount(Request $request, String $id){
        $conta = Conta::find($id);
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'senha' => 'required|min:6'
        ],
        [
            'required' => 'O campo :attribute precisa ser informado!',
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
        $conta->login = $request->input("login");
        $conta->senha = $request->input("senha");
        $sucess = $conta->save();
        if($sucess){
            return response()->json([
                'sucess'=> true,
                'message' => 'Conta editada',
            ], 200);
        }else{
            return response()->json([
                'sucess'=> false,
                'message' => 'Falha!',
            ], 403);
        }
    }
}
