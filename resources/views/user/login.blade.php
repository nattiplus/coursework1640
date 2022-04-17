<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css'); }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Login Wibiu page</title>
</head>
<body>
    <section class="side">
        <img class="imglogin" src="{{ URL::asset('uploads/light.jpg'); }}">
    </section>

    <section class="main">
        <div class="login-container">
            <p class="title">Hi</p>
            <div class="separator"></div>
            <p class="welcome-message">Welcome to private system, sign in to join us</p>

            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-control">
                    <input class="input-login" type="text" id="email" name="email" @error('email') is-invalid @enderror value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                    <i class="fas fa-user"></i>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-control">
                    <input class="input-login" type="password" @error('password') is-invalid @enderror name="password" required autocomplete="current-password" placeholder="Password">
                    <i class="fas fa-lock"></i>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="submit">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </form>
        </div>
    </section>
    
</body>
</html>