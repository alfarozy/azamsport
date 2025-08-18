@extends('layouts.backoffice')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $project }}</h3>

                                <p>Produk</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $article }}</h3>
                                <p>User</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $technology }}</h3>

                                <p>Disewakan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>0</h3>

                                <p>Pemasukan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                {{-- popular --}}
                {{-- <div class="row">

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Article Popular </h4>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td width="5%">#</td>
                                        <td width="75%">Article</td>
                                        <td width="20%">Views</td>
                                    </tr>
                                    @foreach ($article_popular as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ str()->limit($item->title, 80) }}</td>
                                            <td>{{ $item->views }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Project Popular </h4>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td width="5%">#</td>
                                        <td width="75%">Project</td>
                                        <td width="20%">Views</td>
                                    </tr>
                                    @foreach ($project_popular as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ str()->limit($item->title, 80) }}</td>
                                            <td>{{ $item->views }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
