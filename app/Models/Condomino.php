<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condomino extends Model
{
    use HasFactory;

    protected $table = 'condomino'; // Nome da tabela
    
    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

    public function reclamacoes()
{
    return $this->hasMany(Reclamacao::class, 'condomino_id');
}


    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'condominio_id',
        'data_criacao',
    ];
}
