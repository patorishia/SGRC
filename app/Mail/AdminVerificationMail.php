<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    // O usuário associado ao email
    public $user;

    /**
     * Construtor da classe.
     *
     * @param  \App\Models\User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Monta o conteúdo do email.
     *
     * @return \Illuminate\Mail\Mailable
     */

    public function build()
    {
        return $this->view('emails.admin_verification')  // Define a visualização (view) que será usada para o email
            ->subject('New User Registration Verification')  // Define o assunto do email
            ->with([  // Passa os dados que estarão disponíveis na visualização
                'user' => $this->user,  // Passa o objeto User para a view
                'verificationLink' => route('admin.verify', ['user' => $this->user->id]),  // Cria o link de verificação com a rota especificada
            ]);
    }
}


