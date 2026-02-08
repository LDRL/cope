<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio sesion - cope</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->

    <link rel="stylesheet" href="{{asset('assets/compiled/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/compiled/css/app-dark.css')}}">
    <link rel="stylesheet" href="{{asset('assets/compiled/css/iconly.css')}}">

    <link rel="stylesheet" href="{{asset('assets/compiled/css/auth.css')}}">
<body>
    <script src="{{asset('assets/static/js/initTheme.js')}}"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <!-- cambiar el logo a la empresa a usar -->
                        <a href="/"><img src="./assets/compiled/svg/logo.svg" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Iniciar sesión</h1>
                
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Usuario">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="password" type="password" class="form-control form-control-xl @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="current-password"
                            placeholder="Contraseña">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        
                        <button type="submit" 
                        class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Ingresar</button>

                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p><a class="font-bold" href="{{ route('password.request') }}"> ¿ Olvidaste tu contraseña ?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>
</body>


