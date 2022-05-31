@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card login-card">
                <div class="card-body" style="padding: 60px 0px;">
                    <div class="text-center login-title">
                        <h2>LOGIN</h2>
                        <p class="login-text">Preencha seu e-mail e senha abaixo!</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Senha" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-center login-a" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-12 offset-md-5 mt-md-2">
                                <button type="submit" class="btn btn-login">
                                    Entrar
                                </button>
                            </div>
                            <div class="col-md-12 text-center login-text mt-5">

                                @if (Route::has('password.request'))
                                Ainda não tem cadastro? 
                                    <a class="login-a" href="{{ route('register') }}">
                                        Clique aqui
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
