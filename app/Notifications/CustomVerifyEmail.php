<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmailNotification
{
    /**
     * Personaliza o e-mail de verificação.
     *
     * @param  mixed  $notifiable O utilizador que recebe a notificação.
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Verifique o seu E-mail')
                    ->line('Clique no botão abaixo para verificar o seu e-mail.')
                    ->action('Verificar E-mail', url($this->verificationUrl($notifiable)))
                    ->line('Se não criou uma conta, ignore este e-mail.');
    }
}
