<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamacao extends Model
{
    // Define a tabela associada ao modelo
    protected $table = 'reclamacao';

    // Permite atribuição em massa apenas nos seguintes campos
    protected $fillable = [
        'user_id',
        'condominio_id',
        'tipo_reclamacao',
        'descricao',
        'estado_id',
        'created_at',
        'resolved_at',
        'processo'
    ];

    // Garante que os campos de data sejam interpretados corretamente
    protected $casts = [
        'created_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    // Indica que a tabela não tem os campos created_at e updated_at geridos automaticamente pelo Laravel
    public $timestamps = false;

    // Reclamação pertence a um utilizador
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Reclamação está associada a um condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    // Reclamação tem um tipo específico
    public function tipoReclamacao()
    {
        return $this->belongsTo(TiposReclamacao::class, 'tipo_reclamacao');
    }

    // Reclamação tem um estado associado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id');
    }
}
