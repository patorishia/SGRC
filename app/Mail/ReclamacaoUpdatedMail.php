<?php

namespace App\Mail;

use App\Models\Reclamacao;
use App\Models\Condominio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReclamacaoUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    // Reclamação atualizada
    public $reclamacao;

    // Condomínio associado à reclamação
    public $condominio;

    /**
     * Construtor da classe.
     *
     * @param  \App\Models\Reclamacao  $reclamacao
     */
    public function __construct(Reclamacao $reclamacao)
    {
        $this->reclamacao = $reclamacao;
        $this->condominio = Condominio::find($reclamacao->condominio_id);
    }

    /**
     * Monta o conteúdo do email.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject("Reclamação Atualizada")
                    ->view('emails.reclamacao_updated')
                    ->with([
                        'reclamacaoId' => $this->reclamacao->id,
                        'condominioName' => $this->condominio->nome,
                        'reclamacaoUrl' => url('/reclamacoes/' . $this->reclamacao->id),
                    ]);
    }
}
