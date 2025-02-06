<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    // Dados a serem enviados no email
    public $dados;

    /**
     * Construtor da classe.
     *
     * @param  mixed  $dados
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Define o envelope do email (assunto).
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Notificacao Email');
    }

    /**
     * Define o conteúdo do email.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(view: 'emails.notificacao');
    }

    /**
     * Retorna os anexos do email (nenhum neste caso).
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
