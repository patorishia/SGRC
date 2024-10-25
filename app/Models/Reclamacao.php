<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamacao extends Model
{
    // Nome correto da tabela
    protected $table = 'reclamacao'; 

    protected $fillable = [
        'condomino_id', 'condominio_id', 'tipo_reclamacao', 'descricao', 'estado', 'data_criacao', 'data_resolucao'
    ];

    protected $casts = [
        'data_criacao' => 'datetime',
        'data_resolucao' => 'datetime', // Se você tem este campo
    ];

    public $timestamps = false; // Se você não está utilizando os campos created_at e updated_at

    // Defina as relações
    public function condomino()
    {
        return $this->belongsTo(Condomino::class, 'condomino_id');
    }

    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    public function tipoReclamacao()
    {
        return $this->belongsTo(TiposReclamacao::class, 'tipo_reclamacao');
    }
}

