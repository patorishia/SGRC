<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'codigo_postal',
        'data_criacao',
    ];

    protected $table = 'condominios'; // Nome da tabela no banco de dados

    public function condominos()
    {
        return $this->hasMany(Condomino::class);
    }

    public function reclamacoes()
{
    return $this->hasMany(Reclamacao::class, 'condominio_id');
}

}

