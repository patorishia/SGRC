<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Condominio;
use App\Models\User;
use App\Models\TiposReclamacao;
use App\Models\Estado;
use App\Mail\ReclamacaoUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class ReclamacaoController extends Controller
{
    /**
     * Exibe a lista de reclamações filtradas com base nos critérios passados na requisição.
     * O utilizador pode visualizar as reclamações dos seus condomínios ou de todos, dependendo do seu papel (admin ou gestor).
     *
     * @param \Illuminate\Http\Request $request A requisição com os filtros aplicados (condomínio, utilizador, estado).
     * @return \Illuminate\View\View A view com as reclamações filtradas e os dados necessários.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Verificar os condomínios com base no papel do utilizador (admin ou gestor)
        if ($user->role === 'admin') {
            // Se o utilizador for admin, pode visualizar todos os condomínios
            $condominios = Condominio::all();
        } else {
            // Se o utilizador for gestor, mostra apenas os condomínios que ele gere
            $condominios = Condominio::where('manager_id', $user->id)->get();
        }

        // Obter utilizadores associados aos condomínios selecionados
        $users = User::whereIn('condominio_id', $condominios->pluck('id'))->get();

        // Filtrar as reclamações com base nos filtros passados (condominio, user, estado) ou pelo papel do utilizador
        $reclamacoes = Reclamacao::when($request->condominio, function ($query) use ($request) {
            return $query->where('condominio_id', $request->condominio);
        })
            ->when($request->user, function ($query) use ($request) {
                return $query->where('user_id', $request->user);
            })
            ->when($request->estado, function ($query) use ($request) {
                return $query->where('estado_id', $request->estado);
            })
            ->whereIn('condominio_id', $condominios->pluck('id'))  // Filtra pelas reclamações dos condomínios do utilizador
            ->get();

        // Obtém todos os estados possíveis das reclamações
        $estados = Estado::all();

        // Retorna a view com as reclamações filtradas e os dados necessários
        return view('reclamacoes.index', compact('reclamacoes', 'condominios', 'users', 'estados'));
    }

    /**
     * Exibe a página de criação de uma nova reclamação.
     * Preenche os campos do formulário com dados necessários, como os condomínios, utilizadores, tipos de reclamação e estados.
     *
     * @return \Illuminate\View\View A view para criar uma nova reclamação.
     */
    public function create()
    {
        // Obtém o utilizador logado e o seu respetivo condomínio
        $currentUser = Auth::user();
        $currentCondominio = $currentUser->condominio;

        // Obtém todos os condomínios, utilizadores, tipos de reclamação e estados
        $condominios = Condominio::all();
        $users = User::all();
        $tiposReclamacao = TiposReclamacao::all();
        $estados = Estado::all();

        // Passa as informações necessárias para a view de criação de reclamações
        return view('reclamacoes.create', compact('condominios', 'users', 'tiposReclamacao', 'estados', 'currentUser', 'currentCondominio'));
    }

    /**
     * Processa o envio e armazenamento de uma nova reclamação.
     * Valida os dados recebidos, cria a reclamação e a armazena na base de dados.
     *
     * @param \Illuminate\Http\Request $request A requisição com os dados da reclamação.
     * @return \Illuminate\Http\RedirectResponse Redireciona para a página de reclamações com mensagem de sucesso.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos na requisição
        $validatedData = $request->validate([
            'tipo_reclamacao' => 'required|exists:tipos_reclamacao,id',
            'descricao' => 'required|string|max:255',
            'anexos' => 'nullable|array',
            'anexos.*' => 'file|mimes:jpeg,png,jpg,pdf,mp4,avi,mp3|max:10240', // Valida tipos de anexos (imagens, vídeos, documentos)
        ]);

        // Obtém o utilizador logado e o ID do condomínio associado
        $user = Auth::user();
        $condominioId = $user->condominio_id;

        // Cria uma nova reclamação com os dados validados
        $reclamacao = new Reclamacao();
        $reclamacao->condominio_id = $condominioId;
        $reclamacao->user_id = $user->id;
        $reclamacao->tipo_reclamacao = $validatedData['tipo_reclamacao'];
        $reclamacao->descricao = $validatedData['descricao'];

        // Define o estado inicial da reclamação como "pendente" (estado_id = 1)
        $reclamacao->estado_id = Estado::where('nome', 'pendente')->value('id');
        $reclamacao->created_at = now();

        // Define a data de resolução se o estado for "resolvido" (estado_id = 3)
        if ($reclamacao->estado_id == 3) {
            $reclamacao->resolved_at = now();
        } else {
            $reclamacao->resolved_at = null;
        }

        // Processamento de anexos, caso existam
        if ($request->hasFile('anexos')) {
            $anexos = [];
            foreach ($request->file('anexos') as $file) {
                $path = $file->store('anexos', 'public'); // Armazena o arquivo na pasta 'anexos'
                $anexos[] = $path; // Adiciona o caminho do arquivo ao array de anexos
            }
            $reclamacao->anexos = json_encode($anexos); // Converte o array de anexos em JSON
        }

        // Salva a reclamação na base de dados
        $reclamacao->save();

        // Redireciona o utilizador com uma mensagem de sucesso, dependendo do seu papel
        if ($user->role === 'admin') {
            return redirect()->route('reclamacoes.index')->with('success', __('Reclamação criada com sucesso!'));
        } else {
            return redirect()->route('reclamacoes.minhas')->with('success', __('Reclamação criada com sucesso!'));
        }
    }
    /**
     * Exibe a página de edição de uma reclamação específica.
     * Verifica se o utilizador logado tem permissão para editar a reclamação, 
     * caso contrário, redireciona para uma página de erro.
     *
     * @param int $id O ID da reclamação a ser editada.
     * @return \Illuminate\View\View A view de edição com os dados necessários.
     */
    public function edit($id)
    {
        // Obtém a reclamação pelo ID
        $reclamacao = Reclamacao::findOrFail($id);
        $currentUser = Auth::user(); // Obtém o utilizador logado

        // Verifica se o utilizador tem permissão para editar a reclamação
        if ($currentUser->role !== 'admin' && $reclamacao->user_id !== $currentUser->id) {
            // Se o utilizador não tiver permissão, redireciona para uma página de erro
            return redirect()->route('unauthorized');
        }

        // Procura os dados necessários para preencher o formulário de edição
        $users = User::all();
        $condominios = Condominio::all();
        $tipos_reclamacao = TiposReclamacao::all();
        $estados = Estado::all();
        $currentCondominio = $currentUser->condominio;

        // Retorna a view de edição com os dados necessários
        return view('reclamacoes.edit', compact(
            'reclamacao',
            'users',
            'condominios',
            'tipos_reclamacao',
            'estados',
            'currentUser',
            'currentCondominio'
        ));
    }

    /**
     * Atualiza os dados de uma reclamação específica.
     * Valida os dados recebidos e processa os anexos (inclusão ou remoção).
     * Caso a reclamação tenha sido marcada como resolvida, envia um e-mail de notificação ao utilizador.
     *
     * @param \Illuminate\Http\Request $request A requisição com os dados da atualização.
     * @param int $id O ID da reclamação a ser atualizada.
     * @return \Illuminate\Http\RedirectResponse Redireciona para a página de visualização da reclamação.
     */
    public function update(Request $request, $id)
    {
        // Obtém a reclamação pelo ID
        $reclamacao = Reclamacao::findOrFail($id);
        $currentUser = Auth::user(); // Obtém o utilizador logado

        // Verifica se o utilizador tem permissão para atualizar a reclamação
        if (
            $reclamacao->user_id !== $currentUser->id &&
            $currentUser->role !== 'admin' &&
            $currentUser->id !== $reclamacao->condominio->manager_id
        ) {
            // Caso o utilizador não tenha permissão, retorna um erro 403 (não autorizado)
            abort(403, __('Unauthorized action.'));
        }

        // Validação dos dados da requisição
        $validatedData = $request->validate([
            'condominio_id' => 'required|integer',
            'tipo_reclamacao' => 'required|integer',
            'descricao' => 'required|string',
            'estado_id' => 'required|integer',
            'anexos' => 'nullable|array',
            'anexos.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048', // Validação dos anexos (tipos e tamanho)
        ]);

        // Atualiza os campos permitidos
        $reclamacao->condominio_id = $validatedData['condominio_id'];
        $reclamacao->tipo_reclamacao = $validatedData['tipo_reclamacao'];
        $reclamacao->descricao = $validatedData['descricao'];
        $reclamacao->estado_id = $validatedData['estado_id'];

        // Processamento de anexos removidos
        if ($request->has('remove_anexos')) {
            $anexosParaRemover = $request->input('remove_anexos');
            $anexosAtuais = json_decode($reclamacao->anexos, true);
            $novosAnexos = array_diff($anexosAtuais, $anexosParaRemover);

            // Exclui os arquivos removidos do armazenamento
            foreach ($anexosParaRemover as $anexo) {
                Storage::delete('public/' . $anexo);
            }

            // Atualiza a lista de anexos removendo os excluídos
            $reclamacao->anexos = json_encode($novosAnexos);
        }

        // Adiciona novos anexos
        if ($request->has('anexos')) {
            $novosAnexos = [];
            foreach ($request->file('anexos') as $file) {
                $path = $file->store('anexos', 'public');
                $novosAnexos[] = $path;
            }

            // Adiciona os novos anexos aos anexos já existentes
            $anexosAtuais = json_decode($reclamacao->anexos ?? '[]', true);
            $reclamacao->anexos = json_encode(array_merge($anexosAtuais, $novosAnexos));
        }

        // Salva as alterações feitas na reclamação
        $reclamacao->save();

        // Envia e-mail de notificação se o estado da reclamação for "resolvido"
        if ($reclamacao->estado_id == Estado::where('nome', 'resolvido')->first()->id) {
            Mail::to($reclamacao->user->email)->send(new ReclamacaoUpdatedMail($reclamacao));
        }

        // Redireciona para a página de visualização da reclamação com uma mensagem de sucesso
        return redirect()->route('reclamacoes.show', $reclamacao->id)->with('success', __('Reclamação atualizada com sucesso!'));
    }

    /**
     * Exclui uma reclamação específica do Base de dados.
     * O utilizador logado pode excluir a reclamação se for o administrador ou o gestor do condomínio.
     *
     * @param int $id O ID da reclamação a ser excluída.
     * @return \Illuminate\Http\RedirectResponse Redireciona para a página de reclamações com mensagem de sucesso.
     */
    public function destroy($id)
    {
        // Obtém a reclamação a ser excluída
        $reclamacao = Reclamacao::findOrFail($id);

        // Exclui a reclamação da base de dados
        $reclamacao->delete();

        $user = auth()->user(); // Obtém o utilizador logado

        // Redireciona com base no papel do utilizador
        if ($user->role === 'admin') {
            return redirect()->route('reclamacoes.index')->with('success', __('Reclamação apagada com sucesso!'));
        } else {
            return redirect()->route('reclamacoes.minhas')->with('success', __('Reclamação apagada com sucesso!'));
        }
    }

    /**
     * Exibe os detalhes de uma reclamação específica.
     * Apenas o administrador, o utilizador criador da reclamação ou o gestor do condomínio podem visualizar a reclamação.
     * 
     * @param int $id O ID da reclamação a ser visualizada.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Carrega a reclamação juntamente com as suas relações (utilizador, condomínio, tipo de reclamação e estado)
        $reclamacao = Reclamacao::with(['user', 'condominio', 'tipoReclamacao', 'estado'])->findOrFail($id);
        $currentUser = Auth::user();  // Obtém o utilizador autenticado

        // Verifica se o utilizador tem permissão para visualizar a reclamação
        // O utilizador precisa ser admin, o criador da reclamação, ou o gestor do condomínio
        if (
            $currentUser->role !== 'admin' &&
            $reclamacao->user_id !== $currentUser->id &&  // Verifica se o utilizador é o criador da reclamação
            ($reclamacao->condominio->manager_id ?? null) !== $currentUser->id  // Verifica se o utilizador é o gestor do condomínio
        ) {
            // Caso o utilizador não tenha permissão, redireciona para uma página de acesso não autorizado
            return redirect()->route('unauthorized');
        }

        $estados = Estado::all();  // Obtém todos os estados possíveis para as reclamações

        // Retorna a view com os dados da reclamação e os estados
        return view('reclamacoes.show', compact('reclamacao', 'estados'));
    }

    /**
     * Exporta as reclamações filtradas para um arquivo Excel.
     * As reclamações podem ser filtradas por utilizador, estado e condomínio.
     * 
     * @param Request $request Os parâmetros de filtro passados na requisição.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse O arquivo Excel gerado para download.
     */
    public function exportReclamacoesToExcel(Request $request)
    {
        // Obtém os filtros passados na requisição
        $user = $request->query('user');
        $estado = $request->query('estado');
        $condominio = $request->query('condominio');

        // Prepara a query para procurar as reclamações com base nos filtros
        $query = Reclamacao::with(['user', 'condominio', 'estado'])
            ->when($user, fn($q) => $q->where('user_id', $user))  // Filtro por utilizador
            ->when($estado, fn($q) => $q->where('estado_id', $estado))  // Filtro por estado
            ->when($condominio, fn($q) => $q->where('condominio_id', $condominio));  // Filtro por condomínio

        // Executa a query e obtém as reclamações
        $reclamacoes = $query->get();

        // Criação de um novo documento Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define os cabeçalhos das colunas do Excel
        $sheet->setCellValue('A1', __('ID'))
            ->setCellValue('B1', __('Condômino'))
            ->setCellValue('C1', __('Condomínio'))
            ->setCellValue('D1', __('Tipo Reclamação'))
            ->setCellValue('E1', __('Descrição'))
            ->setCellValue('F1', __('Estado'))
            ->setCellValue('G1', __('Data Criação'))
            ->setCellValue('H1', __('Data Resolução'));

        // Preenche os dados das reclamações nas linhas subsequentes
        $row = 2;  // A linha começa na segunda linha (primeira é para os cabeçalhos)
        foreach ($reclamacoes as $reclamacao) {
            // Formata as datas de criação e resolução
            $createdAt = $reclamacao->created_at ? Carbon::parse($reclamacao->created_at)->format('Y-m-d H:i:s') : 'N/A';
            $updatedAt = $reclamacao->resolved_at ? Carbon::parse($reclamacao->resolved_at)->format('Y-m-d H:i:s') : 'N/A';

            // Preenche a linha com os dados da reclamação
            $sheet->setCellValue("A$row", $reclamacao->id)
                ->setCellValue("B$row", $reclamacao->user->name ?? 'N/A')  // Nome do utilizador
                ->setCellValue("C$row", $reclamacao->condominio->nome ?? 'N/A')  // Nome do condomínio
                ->setCellValue("D$row", $reclamacao->tipo_reclamacao ?? 'N/A')  // Tipo de reclamação
                ->setCellValue("E$row", $reclamacao->descricao)  // Descrição da reclamação
                ->setCellValue("F$row", $reclamacao->estado->nome ?? 'N/A')  // Estado da reclamação
                ->setCellValue("G$row", $createdAt)  // Data de criação
                ->setCellValue("H$row", $updatedAt);  // Data de resolução

            // Avança para a próxima linha
            $row++;
        }

        // Cria o escritor do arquivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'reclamacoes_filtered.xlsx';  // Nome do arquivo gerado

        // Define os cabeçalhos HTTP para forçar o download do arquivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Salva o arquivo Excel no formato e envia para o navegador
        $writer->save('php://output');
        exit;  // Interrompe a execução após o envio do arquivo
    }
    /**
     * Exporta as reclamações filtradas para um PDF.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportReclamacoesToPDF(Request $request)
    {
        // Obtém os filtros de user, estado e condominio da query string
        $user = $request->query('user');
        $estado = $request->query('estado');
        $condominio = $request->query('condominio');

        // Cria uma query para obter as reclamações com base nos filtros fornecidos
        $query = Reclamacao::with(['user', 'condominio', 'estado'])
            ->when($user, fn($q) => $q->where('user_id', $user))
            ->when($estado, fn($q) => $q->where('estado_id', $estado))
            ->when($condominio, fn($q) => $q->where('condominio_id', $condominio));

        // Executa a query e obtém as reclamações filtradas
        $reclamacoes = $query->get();

        // Monta o HTML para o relatório em PDF
        $html = '<h1>' . __('Relatório de Reclamações') . '</h1>';
        $html .= '<table border="1" cellspacing="0" cellpadding="5">';
        $html .= '
    <thead>
        <tr>
            <th>' . __('ID') . '</th>
            <th>' . __('Condômino') . '</th>
            <th>' . __('Condomínio') . '</th>
            <th>' . __('Tipo Reclamação') . '</th>
            <th>' . __('Descrição') . '</th>
            <th>' . __('Estado') . '</th>
            <th>' . __('Data Criação') . '</th>
            <th>' . __('Data Resolução') . '</th>
        </tr>
    </thead>
    <tbody>';

        // Preenche as linhas da tabela com as reclamações
        foreach ($reclamacoes as $reclamacao) {
            $createdAt = $reclamacao->created_at ? Carbon::parse($reclamacao->created_at)->format('Y-m-d H:i:s') : 'N/A';
            $updatedAt = $reclamacao->resolved_at ? Carbon::parse($reclamacao->resolved_at)->format('Y-m-d H:i:s') : 'N/A';

            $html .= '<tr>';
            $html .= '<td>' . $reclamacao->id . '</td>';
            $html .= '<td>' . ($reclamacao->user->name ?? 'N/A') . '</td>';
            $html .= '<td>' . ($reclamacao->condominio->nome ?? 'N/A') . '</td>';
            $html .= '<td>' . ($reclamacao->tipo_reclamacao ?? 'N/A') . '</td>';
            $html .= '<td>' . $reclamacao->descricao . '</td>';
            $html .= '<td>' . ($reclamacao->estado->nome ?? 'N/A') . '</td>';
            $html .= '<td>' . $createdAt . '</td>';
            $html .= '<td>' . $updatedAt . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Configura o Dompdf para gerar o PDF
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Define o formato do papel e a orientação
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Exibe o PDF gerado para download
        $dompdf->stream('reclamacoes_filtered.pdf', ['Attachment' => true]);
        exit;
    }

    /**
     * Exibe as reclamações do usuário logado.
     *
     * @return \Illuminate\View\View
     */
    public function minhasReclamacoes()
    {
        $user = Auth::user();

        // Obtém as reclamações do utilizador logado
        $reclamacoes = Reclamacao::where('user_id', $user->id)->get();

        // Passa dados de condomínios e estados, caso necessário
        $condominios = Condominio::all();
        $estados = Estado::all();

        // Retorna a view com as reclamações e os dados auxiliares
        return view('reclamacoes.user.index', compact('reclamacoes', 'condominios', 'estados'));
    }

    /**
     * Exibe a página de pagamento para uma reclamação específica.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pagamento($id)
    {
        $reclamacao = Reclamacao::findOrFail($id);

        // Verifica se o estado da reclamação é "Espera de Pagamento" antes de proceder
        if ($reclamacao->estado->nome !== 'Espera de Pagamento') {
            return redirect()->back()->with('error', __('A reclamação não está no estado "Espera de Pagamento".'));
        }

        // Lógica para exibir a página de pagamento
        return view('reclamacoes.pagamento', compact('reclamacao'));
    }

    /**
     * Finaliza o pagamento de uma reclamação e atualiza o seu estado.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finalizarPagamento($id)
    {
        $reclamacao = Reclamacao::findOrFail($id);

        // Atualiza o estado para indicar que o pagamento foi efetuado
        if ($reclamacao->estado->nome === 'Espera de Pagamento') {
            $reclamacao->estado_id = Estado::where('nome', 'Pago')->firstOrFail()->id;
            $reclamacao->save();

            // Redireciona para a página da reclamação com uma mensagem de sucesso
            return redirect()->route('reclamacoes.show', $id)->with('success', __('Pagamento efetuado com sucesso!'));
        }

        // Caso o pagamento não possa ser processado, exibe uma mensagem de erro
        return redirect()->back()->with('error', __('Não foi possível processar o pagamento.'));
    }

}