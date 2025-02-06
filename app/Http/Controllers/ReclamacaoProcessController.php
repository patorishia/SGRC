<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReclamacaoUpdatedMail;
use App\Mail\ReclamacaoProcessedMail;
use App\Models\Estado;

class ReclamacaoProcessController extends Controller
{
    /**
     * Processa a reclamação, verificando se o utilizador tem permissão e se a reclamação pode ser processada.
     *
     * @param Reclamacao $reclamacao
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function process(Reclamacao $reclamacao)
    {
        // Impede o acesso se o estado da reclamação for 'estado_id = 3' (Resolvido)
        if ($reclamacao->estado_id == 3) {
            return redirect()->back()->with('error', __('Esta reclamação não pode ser processada.'));
        }

        // Verifica se o utilizador é admin ou o gerente do condomínio da reclamação
        if (auth()->user()->role === 'admin' || auth()->user()->id === ($reclamacao->condominio->manager_id ?? null)) {
            // Obtém todos os estados (status) disponíveis
            $estados = Estado::all();

            // Retorna a view para processar a reclamação, passando a reclamação e os estados
            return view('reclamacoes.process', compact('reclamacao', 'estados'));
        }

        // Se o utilizador não tem permissão, redireciona de volta com uma mensagem de erro
        return redirect()->back()->with('error', __('Você não tem permissão para acessar esta página.'));
    }

    /**
     * Atualiza o processo de uma reclamação, incluindo o estado e anexos.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProcess(Request $request, $id)
    {
        $reclamacao = Reclamacao::findOrFail($id);
        $currentUser = auth()->user();

        // Verifica se o utilizador está autorizado 
        if ($reclamacao->user_id !== $currentUser->id && 
            $currentUser->role !== 'admin' && 
            $currentUser->id !== $reclamacao->condominio->manager_id) {
            abort(403, __('Ação não autorizada.'));
        }

        // Valida os dados da requisição
        $validatedData = $request->validate([
            'estado_id' => 'required|integer',
            'processo' => 'nullable|string', 
            'anexos' => 'nullable|array',
            'anexos.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'remove_anexos' => 'nullable|array',
        ]);

        // Verifica se o estado selecionado é 'Resolvido' (estado_id = 3)
        if ($validatedData['estado_id'] == 3) {
            // Define o timestamp 'resolved_at' para o momento atual caso o estado seja 'Resolvido'
            $reclamacao->resolved_at = now(); 
        } else {
            // Garante que 'resolved_at' seja nulo se o estado não for 'Resolvido'
            $reclamacao->resolved_at = null;
        }

        // Atualiza o estado e o campo 'processo'
        $reclamacao->estado_id = $validatedData['estado_id'];
        $reclamacao->processo = $validatedData['processo'] ?? $reclamacao->processo;

        // Lida com a remoção de anexos
        if ($request->has('remove_anexos')) {
            $anexosParaRemover = $request->input('remove_anexos');
            $anexosAtuais = json_decode($reclamacao->anexos, true);
            $novosAnexos = array_diff($anexosAtuais, $anexosParaRemover);

            // Exclui os anexos removidos do armazenamento
            foreach ($anexosParaRemover as $anexo) {
                Storage::delete('public/' . $anexo);
            }

            // Atualiza o campo 'anexos' com os novos anexos
            $reclamacao->anexos = json_encode($novosAnexos);
        }

        // Lida com o upload de novos anexos
        if ($request->has('anexos')) {
            $novosAnexos = [];
            foreach ($request->file('anexos') as $file) {
                $path = $file->store('anexos', 'public');
                $novosAnexos[] = $path;
            }

            // Combina os anexos existentes com os novos anexos
            $anexosAtuais = json_decode($reclamacao->anexos ?? '[]', true);
            $reclamacao->anexos = json_encode(array_merge($anexosAtuais, $novosAnexos));
        }

        // Salva a reclamação atualizada
        $reclamacao->save();

        // Envia email para o gerente do condomínio
        Mail::to($reclamacao->condominio->manager->email)->send(new ReclamacaoUpdatedMail($reclamacao));

        // Envia email para o criador da reclamação
        Mail::to($reclamacao->user->email)->send(new ReclamacaoProcessedMail($reclamacao));

        // Redireciona para a página da reclamação com uma mensagem de sucesso
        return redirect()->route('reclamacoes.show', $reclamacao->id)
                         ->with('success', __('Reclamação atualizada com sucesso!'));
    }
}
