<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Helpers\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListarController extends Controller
{
    public function getAllAccounts(Request $request)
    {
        $crypt = new Cripto();
        $userId = $request->user()->idusuario;
        $contas = Conta::where("idusuario", $userId)->get();
        foreach ($contas as $conta){
            $conta->senha = $crypt->decrypt($conta->senha);
            $conta->login = $crypt->decrypt($conta->login);
        }
        return $contas;
    }

    public function getAccountByName(Request $request, $nome)
    {
        $crypt = new Cripto();
        $userId = $request->user()->idusuario;
        $contas = Conta::where("idusuario", $userId)
            ->where("nome", "like", '%' . $nome . '%')
            ->get();
        foreach ($contas as $conta){
            $conta->senha = $crypt->decrypt($conta->senha);
            $conta->login = $crypt->decrypt($conta->login);
        }
        return $contas;
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
