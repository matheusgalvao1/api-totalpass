<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Conta;
use App\Models\Usuario;

class TesteController extends Controller
{
    public function index(){
        //$contas = DB::select('select nome, login from conta where idconta=6');
        $contas = Usuario::with("contas")->get();
        return $contas;
    }
}
