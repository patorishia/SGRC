<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    // Campos permitidos para atribuição em massa
    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'codigo_postal',
        'manager_id',
        'created_at',
        'updated_at',
    ];

    // Nome da tabela na base de  dados
    protected $table = 'condominio';

    // Relacionamento "um para muitos" com usuários
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relacionamento "um para muitos" com reclamações
    public function reclamacoes()
    {
        return $this->hasMany(Reclamacao::class, 'condominio_id');
    }

    // Relacionamento "muitos para um" com o gestor (usuário)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
