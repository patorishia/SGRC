<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Condominio;
use App\Models\Condomino; // Também importando Condomino se necessário
use App\Models\TiposReclamacao; // Importando TipoReclamacao
use App\Models\Estado;
use App\Mail\NotificacaoEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;


class ReclamacaoController extends Controller
{
    public function index()
{
    // Carregar as reclamações com a relação de estado
    $reclamacoes = Reclamacao::with('estado', 'condominio', 'condomino', 'tipoReclamacao')->get();

    // Passar as reclamações para a view
    return view('reclamacoes.index', compact('reclamacoes'), ['pageTitle' => 'Reclamações']);
}




public function create()
{
    $condominios = Condominio::all(); // Get all condominiums
    $condominos = Condomino::all(); // Get all residents
    $tiposReclamacao = TiposReclamacao::all(); // Get all complaint types
    $estados = Estado::all(); // Get all states

    return view('reclamacoes.create', compact('condominios', 'condominos', 'tiposReclamacao', 'estados'));
}


public function store(Request $request)
{
    $validatedData = $request->validate([
        'condominio_id' => 'required|exists:condominio,id',
        'condomino_nif' => 'required|exists:condomino,nif',
        'tipo_reclamacao' => 'required|exists:tipos_reclamacao,id',
        'descricao' => 'required|string|max:255',
        'estado' => 'required|string|max:255',
        'anexos' => 'nullable|array', // Permite múltiplos anexos
        'anexos.*' => 'file|mimes:jpeg,png,jpg,pdf,mp4,avi,mp3|max:10240', // Validação para os arquivos
    ]);

    $reclamacao = new Reclamacao();
    $reclamacao->condominio_id = $validatedData['condominio_id'];
    $reclamacao->condomino_nif = $validatedData['condomino_nif'];
    $reclamacao->tipo_reclamacao = $validatedData['tipo_reclamacao'];
    $reclamacao->descricao = $validatedData['descricao'];
    $reclamacao->estado = $validatedData['estado'];
    $reclamacao->created_at = now();
    $reclamacao->updated_at = now();

    // Processar anexos
    if ($request->hasFile('anexos')) {
        $anexos = [];
        foreach ($request->file('anexos') as $file) {
            $path = $file->store('anexos', 'public'); // Armazenar no diretório public/anexos
            $anexos[] = $path;
        }
        $reclamacao->anexos = json_encode($anexos); // Salvar caminhos dos arquivos como JSON
    }

    $reclamacao->save();

    return redirect()->route('reclamacoes.index')->with('success', 'Reclamação criada com sucesso!');
}



public function edit($id)
{
    $reclamacao = Reclamacao::findOrFail($id);
    $condominos = Condomino::all(); // Obter todos os condominos
    $condominios = Condominio::all(); // Obter todos os condomínios
    $tipos_reclamacao = TiposReclamacao::all(); // Obter todos os tipos de reclamação

    return view('reclamacoes.edit', compact('reclamacao', 'condominos', 'condominios', 'tipos_reclamacao'));
}

public function update(Request $request, $id)
{
    // Validação dos dados do formulário
    $validatedData = $request->validate([
        'condomino_nif' => 'required|string',
        'condominio_id' => 'required|integer',
        'tipo_reclamacao' => 'required|integer',
        'descricao' => 'required|string',
        'estado' => 'required|string',
        'anexos' => 'nullable|array',
        'anexos.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Obter a reclamação
    $reclamacao = Reclamacao::findOrFail($id);

    // Atualizar os dados da reclamação
    $reclamacao->condomino_nif = $validatedData['condomino_nif'];
    $reclamacao->condominio_id = $validatedData['condominio_id'];
    $reclamacao->tipo_reclamacao = $validatedData['tipo_reclamacao'];
    $reclamacao->descricao = $validatedData['descricao'];
    $reclamacao->estado = $validatedData['estado'];

    // Remover os anexos selecionados para remoção
    if ($request->has('remove_anexos')) {
        $anexosParaRemover = $request->input('remove_anexos');
        
        // Decodificar os anexos atuais para manipular
        $anexosAtuais = json_decode($reclamacao->anexos, true);

        // Filtrando os anexos para remoção
        $novosAnexos = array_diff($anexosAtuais, $anexosParaRemover);

        // Remover os arquivos fisicamente
        foreach ($anexosParaRemover as $anexo) {
            Storage::delete('public/' . $anexo);
        }

        // Atualizar os anexos no banco de dados
        $reclamacao->anexos = json_encode($novosAnexos);
    }

    // Adicionar novos anexos
    if ($request->has('anexos')) {
        $novosAnexos = [];
        foreach ($request->file('anexos') as $file) {
            $path = $file->store('anexos', 'public');
            $novosAnexos[] = $path;
        }

        // Mesclar os novos anexos com os já existentes
        $anexosAtuais = json_decode($reclamacao->anexos ?? '[]', true);
        $reclamacao->anexos = json_encode(array_merge($anexosAtuais, $novosAnexos));
    }

    // Salvar os dados atualizados
    $reclamacao->save();

    return redirect()->route('reclamacoes.index')->with('success', 'Reclamação atualizada com sucesso!');
}



    public function destroy($id)
{
    // Encontre a reclamação pelo ID
    $reclamacao = Reclamacao::findOrFail($id);
    
    // Exclua a reclamação
    $reclamacao->delete();

    // Redirecione de volta para o índice com uma mensagem de sucesso
    return redirect()->route('reclamacoes.index')->with('success', 'Reclamação apagada com sucesso!');
}


    public function show($id)
{
    $reclamacao = Reclamacao::with(['condomino', 'condominio', 'tipoReclamacao'])->findOrFail($id);

    return view('reclamacoes.show', compact('reclamacao'));
}

public function exportReclamacoesToExcel()
     {
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
 
         $sheet->setCellValue('A1', 'ID');
         $sheet->setCellValue('B1', 'Condominio');
         $sheet->setCellValue('C1', 'Condómino');
         $sheet->setCellValue('D1', 'Tipo Reclamação');
         $sheet->setCellValue('E1', 'Estado');
         $sheet->setCellValue('F1', 'Descrição');
         $sheet->setCellValue('G1', 'Data Criação');
         $sheet->setCellValue('H1', 'Última Atualização');
 
         $reclamacoes = Reclamacao::all();
         $row = 2;
 
         foreach ($reclamacoes as $reclamacao) {
             $sheet->setCellValue('A' . $row, $reclamacao->id);
             $sheet->setCellValue('B' . $row, $reclamacao->condominio->nome);
             $sheet->setCellValue('C' . $row, $reclamacao->condomino->nome);
             $sheet->setCellValue('D' . $row, $reclamacao->tipoReclamacao->tipo);
             $sheet->setCellValue('E' . $row, $reclamacao->Estado->nome);
             $sheet->setCellValue('F' . $row, $reclamacao->descricao);
             $sheet->setCellValue('G' . $row, $reclamacao->created_at);
             $sheet->setCellValue('H' . $row, $reclamacao->updated_at);
             $row++;
         }
 
         $writer = new Xlsx($spreadsheet);
         $fileName = 'Reclamacoes.xlsx';
         $writer->save($fileName);
 
         return response()->download($fileName)->deleteFileAfterSend();
     }
 
     // Método para exportar para PDF
     public function exportReclamacoesToPDF()
     {
         $reclamacoes = Reclamacao::all();
         $pdf = PDF::loadView('pdf.reclamacoes', compact('reclamacoes'));
         return $pdf->download('Reclamacoes.pdf');
     }
}
