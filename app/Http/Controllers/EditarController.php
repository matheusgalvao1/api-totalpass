<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Helpers\ValidatorMessages;
use App\Models\Conta;
use Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditarController extends Controller
{
    public function editUser(Request $request){
        $user = $request->user();
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
                errors:$validator->errors()->all(), code:422);; 
        }
        $user->nome = $crypt->encrypt($request->input("nome"));
        $user->sobrenome = $crypt->encrypt($request->input("sobrenome"));
        $user->email = $request->input("email");
        $user->senha = password_hash($request->input("senha"), PASSWORD_DEFAULT);
        $sucess = $user->save();
        if ($sucess){
            return JsonResponse::jsonResponse(type:"default", sucess:true, message:"Usuario editado com sucesso!", code:200);
        }else{
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Falha ao editar usuário", code:400);
        }
    }

    public function editAccount(Request $request, String $id){
        $conta = Conta::find($id);
        $crypt = new Cripto();
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'senha' => 'required|min:6'
        ],
        ValidatorMessages::messages()
        );
        if ($validator->fails()){
            return JsonResponse::jsonResponse(type:"error", sucess:false, message:"Inputs inválidos", 
                errors:$validator->errors()->all(), code:422);
        }
        $userId = $request->user()->idusuario;
        if($userId != $conta->idusuario){
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Usuario nao autorizado", code:401);
        }
        $conta->login = $crypt->encrypt($request->input("login"));
        $conta->senha = $crypt->encrypt($request->input("senha"));
        $sucess = $conta->save();
        if($sucess){
            return JsonResponse::jsonResponse(type:"default", sucess:true, message:"Conta editada com sucesso!", code:200);
        }else{
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Falha ao editar conta", code:400);
        }
    }
}
