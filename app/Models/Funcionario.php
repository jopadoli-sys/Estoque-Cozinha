<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Funcionario extends Model
{
    protected $table = 'funcionario';

    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'data_nascimento',
        'email',
        'nif',
        'senha',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
