<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoReclamacao extends Model
{
    protected $table = 'tipos_reclamacoes';

    public function reclamacoes()
    {
        return $this->hasMany(Reclamacao::class);
    }
}

