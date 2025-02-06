<?php

namespace App\Mail;

use App\Models\Reclamacao;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReclamacaoProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * A reclamação que será enviada no email.
     *
     * @var \App\Models\Reclamacao
     */
    public $reclamacao;

    /**
     * Construtor da classe.
     *
     * @param  \App\Models\Reclamacao  $reclamacao
     */
    public function __construct(Reclamacao $reclamacao)
    {
        $this->reclamacao = $reclamacao;
    }

    /**
     * Constrói o conteúdo do email.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('A sua Reclamação está a ser Processada')
                    ->view('emails.reclamacao_processed')
                    ->with([
                        'reclamacao_id' => $this->reclamacao->id,
                        'condominio_name' => $this->reclamacao->condominio->nome,
                        'estado' => $this->reclamacao->estado->estado,
                    ]);
    }
}
