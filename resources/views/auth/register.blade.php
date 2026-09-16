<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta | GAM Sacaba</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <main class="login-shell">
        <section class="brand-panel" aria-labelledby="brand-title">
            <div class="brand"><span class="brand-mark" aria-hidden="true">S</span><div>GAM SACABA<small>Gobierno Autónomo Municipal</small></div></div>
            <div class="brand-copy"><span class="eyebrow">PARQUE AUTOMOTOR</span><h1 id="brand-title">Gestión de<br>combustible</h1><p>Crea tu cuenta para acceder al sistema de provisión de combustible del municipio.</p><div class="brand-tags"><span>Vehículos</span><span>Vales</span><span>Consumo</span></div></div>
            <p class="brand-footer">Gobierno Autónomo Municipal de Sacaba</p>
        </section>
        <section class="form-panel" aria-labelledby="register-title">
            <div class="form-content">
                <span class="eyebrow">REGISTRO DE USUARIO</span>
                <h2 id="register-title">Crear cuenta</h2>
                <p class="intro">Completa tus datos para comenzar.</p>
                @if ($errors->any())<div class="error-summary" role="alert">Revisa los campos indicados para crear tu cuenta.</div>@endif
                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="field">
                        <label for="name">Nombre completo</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus maxlength="255" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                        @error('name')<p id="name-error" class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="email">Correo electrónico</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required maxlength="254" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email')<p id="email-error" class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="password">Contraseña</label>
                        <input id="password" name="password" type="password" placeholder="Al menos 8 caracteres" autocomplete="new-password" required minlength="8" aria-describedby="password-help @error('password') password-error @enderror" @error('password') aria-invalid="true" @enderror>
                        <p id="password-help" class="password-help">Usa al menos 8 caracteres.</p>
                        @error('password')<p id="password-error" class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required minlength="8">
                    </div>
                    <button class="submit" type="submit">Crear mi cuenta <span aria-hidden="true">→</span></button>
                </form>
                <p class="help">¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>
            </div>
            <footer>GAM Sacaba · Sistema de combustible</footer>
        </section>
    </main>
</body>
</html>
