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
        'estado_id',
        'condominio_id', // ID do condomínio associado
        'condomino_id',// ID do condómino associado
    ];


    // relacionamento com Condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    // relacionamento com Condómino
    public function condomino()
    {
        return $this->belongsTo(Condomino::class, 'condomino_id');
    }



    // relacionamento com TipoReclamacao
    public function tipoReclamacao()
    {
        return $this->belongsTo(TipoReclamacao::class, 'tipo_reclamacao_id');
    }

    // relacionamento com Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
