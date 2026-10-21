<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'origem',
        'tipo',
        'quantidade',
        'validade',
        'descricao'
    ];

    

}