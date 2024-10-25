<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposReclamacao extends Model
{
    use HasFactory;

    protected $table = 'tipos_reclamacao';

    public function reclamacoes()
{
    return $this->hasMany(Reclamacao::class, 'tipo_reclamacao');
}


    protected $fillable = [
        'tipo',
        'descricao',
    ];
}
