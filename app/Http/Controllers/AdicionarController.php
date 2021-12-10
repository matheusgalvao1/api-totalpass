<?php

namespace App\Http\Controllers;

use App\Helpers\Cripto;
use App\Helpers\JsonResponse;
use App\Helpers\ValidatorMessages;
use App\Models\Conta;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        ValidatorMessages::messages()
        );
        if ($validator->fails()){
            return JsonResponse::jsonResponse(type:"error", sucess:false, message:"Inputs inválidos", 
                errors:$validator->errors()->all(), code:422);
        }
        $user->nome = $crypt->encrypt($request->input("nome"));
        $user->sobrenome = $crypt->encrypt($request->input("sobrenome"));
        $user->email = $request->input("email");
        $user->senha = password_hash($request->input("senha"), PASSWORD_DEFAULT);
        $sucess = $user->save();
        if ($sucess){
            $token = $user->createToken("acessToken");
            return JsonResponse::jsonResponse(type:"token", sucess:true, message:"Usuario criado com sucesso!", 
                token:$token->plainTextToken, code:200);
        }else{
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Falha ao criar usuário", code:400);
        }
    }

    public function addAccount(Request $request){
        $conta = new Conta();
        $crypt = new Cripto();
        $validator = Validator::make($request->all(), [
            'nome' => 'required|regex:/^[a-zA-Z ]*$/',
            'login' => 'required',
            'senha' => 'required|min:6'
        ],
        ValidatorMessages::messages()
        );
        if ($validator->fails()){
            return JsonResponse::jsonResponse(type:"error", sucess:false, message:"Inputs inválidos", 
                errors:$validator->errors()->all(), code:422);; 
        }
        $userId = $request->user()->idusuario;
        $conta->nome = $request->input("nome");
        $conta->login = $crypt->encrypt($request->input("login"));
        $conta->senha = $crypt->encrypt($request->input("senha"));
        $conta->idusuario = $userId;
        $sucess = $conta->save();
        if($sucess){
            return JsonResponse::jsonResponse(type:"default", sucess:true, message:"Conta criada com sucesso", code:200);
        }else{
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Falha ao criar conta!", code:400);
        }
    }

}
