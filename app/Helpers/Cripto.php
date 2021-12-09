<?php

namespace App\Helpers;

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