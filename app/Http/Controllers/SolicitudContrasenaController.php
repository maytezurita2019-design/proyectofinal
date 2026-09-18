<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\SolicitudContrasena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SolicitudContrasenaController extends Controller
{
    public function mostrarFormulario()
    {
        return view('auth.olvide-contrasena');
    }

    public function enviarSolicitud(Request $request)
    {
        // 1. Validar los datos ingresados
        $datos = $request->validate([
            'correo' => ['required', 'email'],
            'ci' => ['required', 'string', 'max:30'],
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingrese un correo válido.',
            'ci.required' => 'El CI es obligatorio.',
        ]);

        // 2. Buscar usuario activo con correo y CI coincidentes
        $usuario = Usuario::where('correo', $datos['correo'])
            ->where('ci', $datos['ci'])
            ->where('estado', true)
            ->first();

        if ($usuario) {

            // 3. Verificar si ya tiene una solicitud pendiente
            $solicitudPendiente = SolicitudContrasena::where(
                'usuario_id',
                $usuario->id
            )
                ->where('estado', 'pendiente')
                ->exists();

            // 4. Crear solamente una solicitud nueva
            if (!$solicitudPendiente) {

                SolicitudContrasena::create([
                    'usuario_id' => $usuario->id,
                    'estado' => 'pendiente',
                    'ip_solicitud' => $request->ip(),
                ]);

                // 5. Enviar aviso mediante la API de Brevo
                try {

                    $respuesta = Http::withHeaders([
                        'api-key' => config('services.brevo.api_key'),
                        'accept' => 'application/json',
                        'content-type' => 'application/json',
                    ])
                        ->timeout(10)
                        ->post(
                            'https://api.brevo.com/v3/smtp/email',
                            [
                                'sender' => [
                                    'name' => config(
                                        'services.brevo.remitente_nombre'
                                    ),
                                    'email' => config(
                                        'services.brevo.remitente_correo'
                                    ),
                                ],

                                'to' => [
                                    [
                                        'email' => config(
                                            'services.brevo.admin_correo'
                                        ),
                                    ],
                                ],

                                'subject' =>
                                    'Nueva solicitud de contraseña - SIGECOM',

                                'htmlContent' => '
                                    <h2>SIGECOM</h2>

                                    <p>
                                        Se registró una nueva solicitud
                                        de restablecimiento de contraseña.
                                    </p>

                                    <p>
                                        <strong>Usuario:</strong> '
                                        . e($usuario->nombre) . ' '
                                        . e($usuario->apellido) .
                                        '
                                    </p>

                                    <p>
                                        <strong>Correo:</strong> '
                                        . e($usuario->correo) .
                                        '
                                    </p>

                                    <p>
                                        Ingrese a SIGECOM para revisar
                                        y atender la solicitud.
                                    </p>

                                    <hr>

                                    <small>
                                        Mensaje generado automáticamente
                                        por SIGECOM.
                                    </small>
                                ',
                            ]
                        );

                    if (!$respuesta->successful()) {
                        Log::warning(
                            'Brevo rechazó la notificación de solicitud de contraseña.',
                            [
                                'estado_http' => $respuesta->status(),
                                'usuario_id' => $usuario->id,
                            ]
                        );
                    }

                } catch (\Throwable $e) {

                    // Si Brevo falla, la solicitud NO se pierde.
                    Log::error(
                        'Error al enviar notificación mediante Brevo.',
                        [
                            'usuario_id' => $usuario->id,
                            'error' => $e->getMessage(),
                        ]
                    );
                }
            }
        }

        // 6. Mensaje genérico por seguridad
        return back()->with(
            'estado',
            'Si los datos ingresados corresponden a una cuenta activa, la solicitud fue enviada al administrador.'
        );
    }

    public function index()
    {
        $solicitudes = SolicitudContrasena::with('usuario')
            ->orderByRaw("
                CASE
                    WHEN estado = 'pendiente' THEN 1
                    WHEN estado = 'atendida' THEN 2
                    ELSE 3
                END
            ")
            ->orderByDesc('created_at')
            ->get();

        return view(
            'solicitudes_contrasena.index',
            compact('solicitudes')
        );
    }
}