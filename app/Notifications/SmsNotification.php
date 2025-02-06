<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class SmsNotification extends Notification
{
    use Queueable;

    private $message;

    /**
     * Cria a notificação com a mensagem a ser enviada.
     *
     * @param string $message A mensagem que será enviada por SMS.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Define o canal de entrega da notificação (SMS).
     *
     * @param object $notifiable A entidade que vai receber a notificação.
     * @return array O canal de entrega (Vonage).
     */
    public function via(object $notifiable): array
    {
        return ['vonage']; // Envia via SMS usando Vonage
    }

    /**
     * Define a mensagem de SMS a ser enviada.
     *
     * @param object $notifiable A entidade que vai receber a notificação.
     * @return VonageMessage A mensagem formatada para o envio.
     */
    public function toVonageMessage(object $notifiable)
    {
        return (new VonageMessage)
                ->content($this->message); // Define o conteúdo da mensagem SMS
    }

    /**
     * Representa a notificação em formato de array.
     *
     * @param object $notifiable A entidade que vai receber a notificação.
     * @return array Dados da notificação em formato de array.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
