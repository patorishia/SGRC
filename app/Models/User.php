<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Define os campos que podem ser preenchidos diretamente
    protected $fillable = [
        'nif',
        'name',
        'email',
        'password',
        'telefone',
        'condominio_id',
        'role',
        'profileImage'
    ];

    // Define a chave primária e ativa o auto-incremento
    protected $primaryKey = 'id';
    public $incrementing = true;

    // Um utilizador pertence a um condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    // Um utilizador pode ter outro utilizador como gestor (admin)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Envia uma notificação personalizada de verificação de e-mail
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    // Um utilizador pode ter várias reclamações associadas
    public function reclamacoes()
    {
        return $this->hasMany(Reclamacao::class, 'user_id', 'id');
    }

    // Verifica se o utilizador é administrador
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Define os atributos que devem ser ocultados
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Define os tipos dos atributos
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
