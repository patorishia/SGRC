<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Obtém as regras de validação que se aplicam à solicitação de atualização de perfil.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',   
                'string',     
                'max:255',   
            ],
            'email' => [
                'required',   
                'string',     
                'lowercase',  
                'email',      
                'max:255',    
                Rule::unique(User::class)->ignore($this->user()->id),  // O campo 'email' deve ser único, mas ignora o email do utilizador atual
            ],
        ];
    }
}
