<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conta;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasFactory, HasApiTokens, Authenticatable;
    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    protected $guarded = [];

    public function contas()
    {
        return $this->hasMany(Conta::class, 'idusuario', 'idusuario');
    }
}
