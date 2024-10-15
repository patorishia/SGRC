<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamacao extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_reclamacao',
        'descricao',
        'estado',
        'condominio_id', // ID do condomínio associado
        'condomino_id',// ID do condómino associado
        'created_at',
        'updated_at',
    ];

    // Definindo relacionamento com Condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }
}
