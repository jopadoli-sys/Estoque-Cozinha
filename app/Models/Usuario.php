<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Funcionario;

class Usuario extends Model
{
    protected $table = 'usuario';

    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'data_nascimento',
        'email',
        'nif',
        'senha',
    ];

    public function funcionario()
    {
        return $this->hasOne(Funcionario::class, 'usuario_id');
    }
    
    
}