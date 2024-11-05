<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condomino extends Model
{
    use HasFactory;

    protected $table = 'condomino'; // Nome da tabela
    protected $primaryKey = 'nif'; // Substitua pelo nome correto da chave primária
    public $incrementing = false; // Se a chave primária não é auto-incrementável


    protected $fillable = [
        'nif',
        'nome',
        'email',
        'telefone',
        'condominio_id',
    ];


    public static $rules = [
        'nif' => 'required|numeric|digits:8|unique:condomino,nif',  // NIF deve ser único e ter 8 dígitos
        'nome' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telefone' => 'nullable|string|max:15', // O telefone pode ser opcional
        'condominio_id' => 'required|exists:condominio,id', // Verifica se o condomínio existe
    ];

    // relacionamento com reclamacao
    public function reclamacoes()
    {
        return $this->hasMany(Reclamacao::class, 'condomino_id');
    }

}
