@extends('layouts.backoffice')
@section('title', 'Users')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>List Users </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-sm-6 col-lg-6">
                                        <h3 class="card-title mt-2 ">@yield('title')</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
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
                                <table id="datatable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="40%">Fullname</th>
                                            <th width="26%">Email</th>
                                            <th width="14%" class="text-center">Register date</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $item->name }}
                                                    <div class="float-right">

                                                        <span class="badge bg-secondary">{{ $item->role }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ $item->email }}</td>
                                                <td class="align-middle text-center">
                                                    {{ $item->created_at->translatedFormat('d-F-Y') }} </td>
                                                <td class="align-middle text-center">
                                                    @if ($item->enabled == 1)
                                                        <button class="btn btn-sm btn-success">Active</button>
                                                    @else
                                                        <button class="btn btn-sm btn-danger">Nonactive</button>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex justify-content-center">

                                                        <a href="{{ route('users.show', $item->id) }}"
                                                            class="m-1 btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Detail data"><i
                                                                class="fa fa-address-card"></i></a>

                                                        @if ($item->enabled == 1)
                                                            <a href="{{ route('users.setActive', $item->id) }}"
                                                                class="m-1 ml-2 btn btn-sm btn-danger"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Disabled"><i class="fa fa-times"></i></a>
                                                        @else
                                                            <a href="{{ route('users.setActive', $item->id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Enabled" class="m-1 ml-2 btn btn-sm btn-success"><i
                                                                    class="fa fa-check"></i></a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
