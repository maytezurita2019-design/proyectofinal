<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AutenticacionController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validar los campos del formulario
        $datos = $request->validate([
            'correo' => ['required', 'email'],
            'contrasena' => ['required', 'string'],
            'cf-turnstile-response' => ['required', 'string'],
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingrese un correo válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'cf-turnstile-response.required' =>
                'Complete la verificación de seguridad.',
        ]);

        // 2. Verificar el token de Turnstile con Cloudflare
        try {
            $respuestaTurnstile = Http::asForm()
                ->timeout(10)
                ->post(
                    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                    [
                        'secret' => config('services.turnstile.secret_key'),
                        'response' => $datos['cf-turnstile-response'],
                        'remoteip' => $request->ip(),
                    ]
                );

            if (
                !$respuestaTurnstile->successful() ||
                !$respuestaTurnstile->json('success')
            ) {
                return back()
                    ->withErrors([
                        'turnstile' =>
                            'No se pudo completar la verificación de seguridad. Intente nuevamente.',
                    ])
                    ->onlyInput('correo');
            }

        } catch (\Throwable $e) {
            return back()
                ->withErrors([
                    'turnstile' =>
                        'No se pudo conectar con el servicio de verificación. Intente nuevamente.',
                ])
                ->onlyInput('correo');
        }

        // 3. Recordarme
        $recordarme = $request->boolean('recordarme');

        // 4. Intentar iniciar sesión
        if (Auth::attempt([
            'correo' => $datos['correo'],

            // IMPORTANTE:
            // Laravel necesita "password" aquí.
            // NO cambiar por "contrasena".
            'password' => $datos['contrasena'],

            'estado' => true,
        ], $recordarme)) {

            // 5. Regenerar la sesión por seguridad
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        // 6. Credenciales incorrectas
        return back()
            ->withErrors([
                'correo' => 'El correo o la contraseña son incorrectos.',
            ])
            ->onlyInput('correo');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}