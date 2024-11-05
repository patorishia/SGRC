<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoReclamacao extends Model
{
    use HasFactory;

    protected $table = 'tipos_reclamacao';

    protected $fillable = [
        'tipo',
    ];

    public function reclamacoes()
    {
        return $this->hasMany(Reclamacao::class);
    }
}

