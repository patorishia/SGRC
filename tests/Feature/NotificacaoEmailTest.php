<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacaoEmail;
use Tests\TestCase;

class NotificacaoEmailTest extends TestCase
{
    public function test_email_notificacao()
    {
        // Finge o envio de e-mails
        Mail::fake();

        
        // simular um pedido POST que envia um e-mail
        $this->post('/enviar-notificacao', [
            'email' => 'usuario@exemplo.com',
        ]);

        // Verifica se um e-mail foi enviado
        Mail::assertSent(NotificacaoEmail::class, function ($mail) {
            return $mail->hasTo('usuario@exemplo.com');
        });
    }
}
