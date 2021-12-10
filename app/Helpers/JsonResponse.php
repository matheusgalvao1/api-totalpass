<?php

namespace App\Helpers;

class JsonResponse{
    public static function jsonResponse($type, $sucess, $message=null, $errors=null, $token=null, $user=null, $code){
        switch($type){
            case "error": {
                return response()->json([
                    'success'=> false,
                    'message' => $message,
                    'errors' => $errors,
                ], $code);
            }break;
            case "default": {
                return response()->json([
                    'success'=> $sucess,
                    'message' => $message
                ], $code);
            }break;
            case 'login':{
                return response()->json([
                    'success'=> $sucess,
                    'message' => $message,
                    'token' => $token,
                    'usuario' => $user
                ], $code);
            }break;
            case "token": {
                return response()->json([
                    'success'=> $sucess,
                    'message' => $message,
                    'token' => $token
                ], $code);
            }
        }
    }
}