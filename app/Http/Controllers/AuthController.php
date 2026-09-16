<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function register(): View
    {
        return view('auth.register');
    }

    public function storeRegistration(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:254', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Ingresa tu nombre completo.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'email.required' => 'Ingresa tu correo electrónico.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.max' => 'El correo no puede superar los 254 caracteres.',
            'email.unique' => 'Este correo ya tiene una cuenta. Inicia sesión.',
            'password.required' => 'Ingresa una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function create(): View
    {
        return view('auth.login');
    }

public function store(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'email' => ['required', 'string', 'email', 'max:254'],
        'password' => ['required', 'string'],
        'remember' => ['sometimes', 'boolean'],
        'cf-turnstile-response' => ['required', 'string'],
    ], [
        'email.required' => 'Ingresa tu correo electrónico.',
        'email.email' => 'Ingresa un correo electrónico válido.',
        'password.required' => 'Ingresa tu contraseña.',
        'cf-turnstile-response.required' => 'Completa la verificación de seguridad.',
    ]);

    $key = 'login:'.Str::lower(
        $request->string('email')->toString()
    ).'|'.$request->ip();

    if (RateLimiter::tooManyAttempts($key, 5)) {
        throw ValidationException::withMessages([
            'email' => 'Demasiados intentos. Intenta nuevamente en '
                .RateLimiter::availableIn($key)
                .' segundos.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Verificación con Cloudflare Turnstile
    |--------------------------------------------------------------------------
    */

    try {
        $turnstile = Http::asForm()
            ->timeout(10)
            ->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]
            );

        if (
            $turnstile->failed() ||
            ! $turnstile->json('success')
        ) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' =>
                    'No se pudo completar la verificación de seguridad. Intenta nuevamente.',
            ]);
        }
    } catch (ValidationException $exception) {
        throw $exception;
    } catch (\Throwable $exception) {
        throw ValidationException::withMessages([
            'cf-turnstile-response' =>
                'El servicio de verificación no está disponible. Intenta nuevamente.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Autenticación de Laravel
    |--------------------------------------------------------------------------
    */

    if (! Auth::attempt(
        [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ],
        $request->boolean('remember')
    )) {
        RateLimiter::hit($key, 60);

        throw ValidationException::withMessages([
            'email' => 'El correo o la contraseña son incorrectos.',
        ]);
    }

    RateLimiter::clear($key);

    $request->session()->regenerate();

    return redirect()->intended(route('dashboard'));
}

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Has cerrado sesión correctamente.');
    }
}
