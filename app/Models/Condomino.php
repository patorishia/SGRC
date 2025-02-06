<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condomino extends Model
{
    use HasFactory;

    // Chave primária personalizada (NIF)
    protected $primaryKey = 'nif';

    // Nome da tabela no banco de dados
    protected $table = 'condomino';

    // Relacionamento "muitos para um" com Condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    // Relacionamento "um para muitos" com Reclamações
    public function reclamacoes()
    {
        return $this->hasMany(Reclamacao::class, 'condomino_nif', 'nif');
    }

    // Campos permitidos para atribuição em massa
    protected $fillable = [
        'nif',
        'nome',
        'email',
        'email_verified_at',
        'password',
        'telefone',
        'condominio_id',
        'role',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    // Campos ocultos em respostas JSON/arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast de atributos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
