<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    use HasFactory;
    protected $table = 'condominio'; // Nome da tabela

    // Campos 
    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'codigo_postal',
        'created_at',
        'updated_at',
    ];
}
