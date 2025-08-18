@extends('layouts.backoffice')
@section('title', 'Ubah password saya')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ubah password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Ubah Password</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('msg'))
                                    <div class="alert bg-success text-center">
                                        {{ session()->get('msg') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert bg-danger text-center">
                                        {{ session()->get('error') }}
                                    </div>
                                @endif
                                <form action="{{ route('update-password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="inputName" class="col-form-label">Password baru</label>
                                        <input type="password" name="password" class="form-control" id="inputName">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="inputName" class="col-form-label">Konfirmasi password
                                            baru</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="inputName">
                                        @error('password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-form-label">Password lama</label>
                                        <input type="password" name="old_password" class="form-control" id="inputName">
                                        @error('new_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @else
                                            <small class="text-muted">Untuk alasan keamanan silahkan inputkan password
                                                lama</small>
                                        @enderror
                                    </div>


                                    <button type="submit" class="btn btn-success">Ubah password</button>

                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
