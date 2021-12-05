<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListarController extends Controller
{
    public function getAllAccounts(Request $request){}
    public function getAccountByName(Request $request, $nome){}
    public function getAccountsRanking(){}
    public function getAccountOccurrences($nome){}
}
