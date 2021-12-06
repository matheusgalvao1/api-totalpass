<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListarController extends Controller
{
    public function getAllAccounts(Request $request){}
    public function getAccountByName(Request $request, $nome){}
    public function getAccountsRanking(){
        return DB::table('conta')
        ->selectRaw('nome, COUNT(*) as ocorrencias')
        ->groupBy('nome')
        ->orderBy('ocorrencias', 'desc')
        ->get();
    }
    public function getAccountOccurrences($nome){
    }
}
