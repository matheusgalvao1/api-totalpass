<?php

namespace App\Helpers;

class JsonResponse{
    public static function jsonResponse($type, $sucess, $message=null, $errors=null, $token=null, $code){
        switch($type){
            case "error": {
                return response()->json([
                    'sucess'=> false,
                    'message' => $message,
                    'errors' => $errors,
                ], $code);
            }break;
            case "default": {
                return response()->json([
                    'sucess'=> $sucess,
                    'message' => $message
                ], $code);
            }break;
            case "token": {
                return response()->json([
                    'sucess'=> $sucess,
                    'message' => $message,
                    'token' => $token
                ], $code);
            }
        }
    }
}