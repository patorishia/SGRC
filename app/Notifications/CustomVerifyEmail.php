<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends VerifyEmailNotification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Verifique seu E-mail')
                    ->line('Por favor, clique no botão abaixo para verificar seu e-mail.')
                    ->action('Verificar E-mail', url($this->verificationUrl($notifiable)))
                    ->line('Se você não criou uma conta, nenhuma ação adicional é necessária.');
    }
}
