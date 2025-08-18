@extends('layouts.auth')

@section('title', 'Lupa password')
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
                <p class="login-box-msg">Silahkan inputkan email anda, kami akan mengirim instruksi untuk reset passwordnya
                </p>

                <form action="{{ route('forgetpassword.send') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}" class="text-primary">Kembali kehalaman login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

@endsection
