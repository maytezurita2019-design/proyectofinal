<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | GAM Sacaba</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <script
    src="https://challenges.cloudflare.com/turnstile/v0/api.js"
    async
    defer>
</script>
</head>
<body>
    <main class="login-shell">
        <section class="brand-panel" aria-labelledby="brand-title">
            <div class="brand"><span class="brand-mark" aria-hidden="true">S</span><div>GAM SACABA<small>Gobierno Autónomo Municipal</small></div></div>
            <div class="brand-copy"><span class="eyebrow">PARQUE AUTOMOTOR</span><h1 id="brand-title">Gestión de<br>combustible</h1><p>Un solo lugar para consultar y organizar la provisión de combustible del municipio.</p><div class="brand-tags"><span>Vehículos</span><span>Vales</span><span>Consumo</span></div></div>
            <p class="brand-footer">Gobierno Autónomo Municipal de Sacaba</p>
        </section>
        <section class="form-panel" aria-labelledby="login-title">
            <div class="form-content">
                <span class="eyebrow">ACCESO AL SISTEMA</span>
                <h2 id="login-title">Bienvenido</h2>
                <p class="intro">Autenticarse para iniciar sesion.</p>
                @if (session('status'))<div class="status" role="status">{{ session('status') }}</div>@endif
                @if ($errors->any())<div class="error-summary" role="alert">{{ $errors->first() }}</div>@endif
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Correo electrónico</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nombre@ejemplo.com" autocomplete="username" required autofocus maxlength="254" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email')<p id="email-error" class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="password">Contraseña</label>
                        <div class="password-field"><input id="password" name="password" type="password" placeholder="Ingresa tu contraseña" autocomplete="current-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror><button type="button" id="toggle-password" aria-controls="password" aria-pressed="false" hidden>Mostrar</button></div>
                        @error('password')<p id="password-error" class="field-error">{{ $message }}</p>@enderror
                    </div>
                   <label class="remember">
    <input
        type="checkbox"
        name="remember"
        value="1"
        @checked(old('remember'))
    >
    Recordarme
</label>

<div class="turnstile-container">
    <div
        class="cf-turnstile"
        data-sitekey="{{ config('services.turnstile.site_key') }}"
        data-theme="light"
    ></div>

    @error('cf-turnstile-response')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>
<button class="submit" type="submit">
    Iniciar sesión <span aria-hidden="true">→</span>
</button>
                    
                </form>
                <p class="help">¿Aún no tienes cuenta? <a href="{{ route('register') }}">Crear cuenta</a><br>Si necesitas ayuda con tu contraseña, contacta al administrador.</p>
            </div>
            <footer>GAM Sacaba · Sistema de combustible</footer>
        </section>
    </main>
    <script>
        const toggle = document.getElementById('toggle-password');
        const password = document.getElementById('password');
        toggle.hidden = false;
        toggle.addEventListener('click', function () {
            const visible = password.type === 'password';
            password.type = visible ? 'text' : 'password';
            toggle.textContent = visible ? 'Ocultar' : 'Mostrar';
            toggle.setAttribute('aria-pressed', String(visible));
        });
    </script>
</body>
</html>
