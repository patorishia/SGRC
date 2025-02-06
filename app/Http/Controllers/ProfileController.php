<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Método para exibir o perfil do utilizador
    public function show()
    {
        return view('profile.profile'); // Exibe a visualização do perfil
    }

    // Método para editar o perfil do utilizador
    public function edit()
    {
        return view('profile.profile');
    }

    // Método para atualizar as informações do perfil
    public function update(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->user()->id,
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Valida o arquivo de imagem
        ]);

        // Obtém o utilizador autenticado
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Tratamento do upload da imagem de perfil
        if ($request->hasFile('profileImage')) {
            // Elimina a imagem antiga, caso exista
            if ($user->profileImage) {
                Storage::delete('public/profileImages/' . $user->profileImage);
            }

            // Guarda a nova imagem
            $imageName = time() . '.' . $request->profileImage->extension();
            $request->profileImage->storeAs('profileImages', $imageName);

            // Atualiza o caminho da imagem de perfil
            $user->profileImage = $imageName;
        }

        // Salva as alterações no perfil
        $user->save();

        // Redireciona para a página de edição com uma mensagem de sucesso
        return redirect()->route('profile.edit')->with('success', __('Perfil atualizado com sucesso.'));
    }
}
