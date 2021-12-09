<?php

namespace App\Helpers;

class ValidatorMessages{
    public static function messages(){
        return [
            'required' => 'O campo :attribute precisa ser informado!',
            'regex' => 'O campo :attribute inserido não é valido!',
            'email' => 'O email inserido não está no formato correto',
            'unique' => 'O email inserido já está em uso!',
            'min' => 'A senha precisa ter pelo menos 6 elementos!'
        ];
    }
}