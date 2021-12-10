<?php

namespace App\Http\Controllers;

use App\Helpers\Cripto;
use App\Helpers\JsonResponse;
use App\Helpers\ValidatorMessages;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'senha' => 'required|min:6'
        ],
        ValidatorMessages::messages()
        );
        if ($validator->fails()){
            return JsonResponse::jsonResponse(type:"error", sucess:false, message:"Falha no input!", 
                errors:$validator->errors()->all(), code:422);
        }
        $user = Usuario::where('email', $request->input('email'))->get();
        if (empty($user[0])){
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Email ou senha inválidos!", 
                errors:$validator->errors()->all(), code:422);
        }
        $user = $user[0];
        if (password_verify($request->input("senha"), $user->senha)){
            $crypt = new Cripto();
            $token = $user->createToken("acessToken");
            $user->nome = $crypt->decrypt($user->nome);
            $user->sobrenome = $crypt->decrypt($user->sobrenome);
            return JsonResponse::jsonResponse(type:"login", sucess:true, message:"Login realizado com sucesso!", 
                token:$token->plainTextToken, user:$user, code:200);
        } else{
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Email ou senha inválidos!", 
                errors:$validator->errors()->all(), code:422);
        }
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return JsonResponse::jsonResponse(type:"default", sucess:true, message:"Logout realizado com sucesso!", code:200);
    }
}
