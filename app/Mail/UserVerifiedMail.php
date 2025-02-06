<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    // Utilizador verificado
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
        return $this->view('emails.user_verified')
                    ->with([
                        'name' => $this->user->name,
                    ]);
    }
}
