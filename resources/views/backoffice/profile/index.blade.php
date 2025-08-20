@extends('layouts.backoffice')
@section('title', 'Profil saya')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profil saya</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profil</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('msg'))
                                    <div class="alert bg-success text-center">
                                        {{ session()->get('msg') }}
                                    </div>
                                @endif
                                <form action="{{ route('profile') }}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputName" class="col-lg-2 col-form-label">Fullname</label>
                                        <div class="col-lg-10">
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="form-control" id="inputName">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-lg-2 col-form-label">Email</label>
                                        <div class="col-lg-10">
                                            <input type="email" name="email" readonly value="{{ $user->email }}"
                                                class="form-control" id="inputEmail">

                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-right">

                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
