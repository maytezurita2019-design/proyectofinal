<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\SolicitudContrasena;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')
            ->orderBy('nombre')
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:usuarios,ci',
            'correo' => 'required|email|max:150|unique:usuarios,correo',
            'contrasena' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
            'estado' => 'required|boolean',
        ]);

        Usuario::create($datos);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('rol');

        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        $roles = Rol::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',

            'ci' => [
                'required',
                'string',
                'max:20',
                Rule::unique('usuarios', 'ci')->ignore($usuario->id),
            ],

            'correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('usuarios', 'correo')->ignore($usuario->id),
            ],

            'contrasena' => 'nullable|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
            'estado' => 'required|boolean',
        ]);

        if (empty($datos['contrasena'])) {
            unset($datos['contrasena']);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->valesCombustible()->exists()) {
            return redirect()->route('usuarios.index')
                ->with(
                    'error',
                    'No se puede eliminar porque tiene vales registrados.'
                );
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function mostrarRestablecerContrasena(Usuario $usuario)
    {
        return view(
            'usuarios.restablecer-contrasena',
            compact('usuario')
        );
    }

    public function restablecerContrasena(
        Request $request,
        Usuario $usuario
    ) {
        $datos = $request->validate([
            'contrasena' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'contrasena.required' =>
                'La nueva contraseña es obligatoria.',

            'contrasena.min' =>
                'La contraseña debe tener al menos 8 caracteres.',

            'contrasena.confirmed' =>
                'Las contraseñas no coinciden.',
        ]);

        // 1. Cambiar la contraseña del usuario
        $usuario->contrasena = $datos['contrasena'];
        $usuario->save();


        // 2. Marcar su solicitud pendiente como atendida
        SolicitudContrasena::where('usuario_id', $usuario->id)
            ->where('estado', 'pendiente')
            ->update([
                'estado' => 'atendida',
                'fecha_atencion' => now(),
                'atendido_por' => auth()->id(),
            ]);


        // 3. Regresar al listado de usuarios
        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'La contraseña de '.$usuario->nombre.
                ' fue restablecida correctamente.'
            );
    }
}