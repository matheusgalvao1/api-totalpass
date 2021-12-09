<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListarController extends Controller
{
    public function getAllAccounts(Request $request)
    {
        $userToken = $request->header("userToken");
        $retorno = Usuario::where("token", $userToken)->first("idusuario");
        return DB::table('conta')
            ->where("idusuario", $retorno["idusuario"])
            ->get();
    }

    public function getAccountByName(Request $request, $nome)
    {
        $userToken = $request->header("userToken");
        $retorno = Usuario::where("token", $userToken)->first("idusuario");
        return DB::table('conta')
            ->where("idusuario", $retorno["idusuario"])
            ->where("nome", "like", '%' . $nome . '%')
            ->get();
    }

    public function getAccountsRanking()
    {
        return DB::table('conta')
            ->selectRaw('nome, COUNT(*) as ocorrencias')
            ->groupBy('nome')
            ->orderBy('ocorrencias', 'desc')
            ->get();
    }

    public function getAccountOccurrences($nome)
    {
        return DB::table('conta')
            ->where('nome', $nome)
            ->selectRaw('nome, COUNT(*) as ocorrencias')
            ->groupBy('nome')
            ->get();
    }
}
