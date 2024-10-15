<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    use HasFactory;
    protected $table = 'condominio'; // Nome da tabela

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'codigo_postal',
    ];
}
