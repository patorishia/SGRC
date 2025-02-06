<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposReclamacao extends Model
{
    use HasFactory;

    // Define a tabela associada ao modelo
    protected $table = 'tipos_reclamacao';

    // Permite atribuição em massa apenas nestes campos
    protected $fillable = [
        'tipo',        
        'descricao',  
    ];

    // Um tipo de reclamação pode estar associado a várias reclamações
    public function reclamacoes()
    {
        return $this->hasMany(Reclamacao::class, 'tipo_reclamacao');
    }
}
