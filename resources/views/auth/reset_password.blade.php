@extends('layouts.auth')

@section('title', 'Perbarui password')
@section('content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body rounded">
                @if (session()->has('error'))
                    <div class="alert bg-danger text-center">
                        {!! session()->get('error') !!}
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert bg-success text-center">
                        {!! session()->get('success') !!}
                    </div>
                @endif
                <div class="text-center my-4 mb-5">
                    <img class="col-4" src="/frontoffice/img/logo.png" alt="" srcset="">
                </div>
                <p class="login-box-msg">Silahkan inputkan password baru anda</p>

                <form action="{{ route('update.password') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="text" id="token" name="token" value="{{ $user->token }}" hidden>
                    <input type="text" id="email" name="email" value="{{ $user->email }}" hidden>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Ubah Password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}" class="text-primary">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
