<?php

use App\Http\Controllers\AdicionarController;
use App\Http\Controllers\EditarController;
use App\Http\Controllers\ListarController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("/addUser", [AdicionarController::class, 'addUser']); //Adiciona novo usuário
Route::post("/addAccount", [AdicionarController::class, 'addAccount'])->middleware('auth:sanctum'); //Adiciona nova conta a um usuário
Route::post("/login", [LoginController::class, 'login']); //Realiza login, recebe token
Route::post("/logout", [LoginController::class, 'logout'])->middleware('auth:sanctum'); //Exclue tokens do usuário especifico do banco
Route::post("/editAccount/{id}", [EditarController::class, 'editAccount'])->middleware('auth:sanctum'); //Edita uma conta a partir de um id
Route::post("/editUser", [EditarController::class, 'editUser'])->middleware('auth:sanctum');//Edita um usuário a partir do token
Route::get("/getAccounts", [ListarController::class, 'getAllAccounts'])->middleware('auth:sanctum'); //Retorna contas de um dado usuário
Route::get("/getAccountByName/{nome}", [ListarController::class, 'getAccountByName'])->middleware('auth:sanctum'); //Retorna uma conta específica do usuário
Route::get("/getAccountsRanking", [ListarController::class, 'getAccountsRanking']); //Retorna uma lista de nomes de contas no banco e quantos usuários as possuem
Route::get("/getAccountOccurrences/{nome}", [ListarController::class, 'getAccountOccurrences']); //Retorna o número de ocorrências de uma dada conta na plataforma
