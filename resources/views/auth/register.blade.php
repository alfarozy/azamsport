@extends('layouts.auth')
@section('title', 'Register')

@section('content')
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body rounded">
                @if (session()->has('msg'))
                    <div class="alert bg-danger text-center">
                        {!! session()->get('msg') !!}
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert bg-success text-center">
                        {!! session()->get('success') !!}
                    </div>
                @endif

                <div class="text-center my-4 mb-5">
                    <img class="col-4" src="/frontoffice/img/logo.png" alt="Logo">
                </div>

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Konfirmasi Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="social-auth-links text-center mb-3">
                        <button type="submit" class="btn btn-block btn-primary"> Register </button>
                    </div>
                </form>

                <p class="text-center mt-3">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
@endsection
