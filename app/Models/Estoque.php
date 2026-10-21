<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $table = 'estoque';

    protected $fillable = [
        'produtos_id',
        'validade',
        'descricao'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produtos_id');
    }

}