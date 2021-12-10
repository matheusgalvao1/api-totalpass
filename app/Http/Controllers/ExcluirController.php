<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Models\Conta;
use Illuminate\Http\Request;

class ExcluirController extends Controller
{
    public function deleteUser(Request $request){
    }

    public function deleteAccount(Request $request, $id){
        $conta = Conta::find($id);
        $success = $conta->delete();
        if($success){
            return JsonResponse::jsonResponse(type:"default", sucess:true, message:"Conta excluida com sucesso!", code:200);
        }else{
            return JsonResponse::jsonResponse(type:"default", sucess:false, message:"Falha ao excluir conta", code:400);
        }
    }
}
