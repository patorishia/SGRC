<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamacao extends Model
{
    use HasFactory;
    protected $table = 'reclamacao'; 
    protected $fillable = [
        'tipo_reclamacao_id',
        'descricao',
        'estado',
        'condominio_id', // ID do condomínio associado
        'condomino_id',// ID do condómino associado
    ];

    // Definindo relacionamento com Condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

    public function tipoReclamacao()
    {
        return $this->belongsTo(TipoReclamacao::class, 'tipo_reclamacao_id');
    }
}
