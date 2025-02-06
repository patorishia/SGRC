<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determina se o utilizador tem permissão para fazer esta solicitação.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Permite todas as solicitações, independentemente do utilizador
        return true;
    }

    /**
     * Obtém as regras de validação que se aplicam à solicitação de login.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],  
            'password' => ['required', 'string'],  
        ];
    }

    /**
     * Tenta autenticar as credenciais da solicitação de login.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        // Verifica se a solicitação não excedeu o limite de tentativas
        $this->ensureIsNotRateLimited();

        // Tenta autenticar o utilizador com as credenciais fornecidas
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Se a autenticação falhar, aumenta o contador de tentativas
            RateLimiter::hit($this->throttleKey());

            // Lança uma exceção de validação com uma mensagem de falha na autenticação
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),  // A mensagem de erro relacionada com o email
            ]);
        }

        // Limpa o contador de tentativas de autenticação, caso a autenticação tenha sucesso
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Garante que a solicitação de login não excedeu o limite de tentativas.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Verifica se o número de tentativas de login excedeu o limite
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;  // Caso o limite não tenha sido excedido, a solicitação pode continuar
        }

        // Se o limite de tentativas for excedido, dispara o evento de bloqueio
        event(new Lockout($this));

        // Obtém o tempo restante até que as tentativas sejam reiniciadas
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Lança uma exceção de validação com uma mensagem informando sobre o bloqueio
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,  // Tempo restante em segundos
                'minutes' => ceil($seconds / 60),  // Tempo restante arredondado em minutos
            ]),
        ]);
    }

    /**
     * Obtém a chave de limitação de taxa para a solicitação.
     *
     * @return string
     */
    public function throttleKey(): string
    {
        // Gera uma chave única para o utilizador com base no email e no endereço IP
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
