<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conta;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    protected $guarded = [];

    public function contas()
    {
        return $this->hasMany(Conta::class, 'idusuario', 'idusuario');
    }
}
