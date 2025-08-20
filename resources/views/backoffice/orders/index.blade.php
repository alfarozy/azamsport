@extends('layouts.backoffice')
@section('title', 'Rental Orders')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>List @yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
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
                                    <div class="col-sm-6 col-lg-6  text-right ">
                                        <a href="{{ route('homepage.products') }}" class="btn btn-success btn-sm m-1"> <i
                                                class="fa fa-arrow-right"></i>
                                            Lihat produk lainnya</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (session()->has('success'))
                                    <div class="alert bg-success fade show" role="alert">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert bg-danger fade show" role="alert">
                                        {{ session()->get('error') }}
                                    </div>
                                @endif

                                <table id="datatable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Order #</th>
                                            <th>Produk</th>
                                            <th>User</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td><b>{{ $item->order_number }}</b></td>
                                                <td>{{ $item->product->name ?? '-' }}</td>
                                                <td>{{ $item->user->name ?? '-' }}</td>
                                                <td>
                                                    {{ date('d M Y', strtotime($item->start_date)) }} -
                                                    {{ date('d M Y', strtotime($item->end_date)) }}
                                                </td>
                                                <td>Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($item->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif ($item->status == 'confirmed')
                                                        <span class="badge bg-success">Confirmed</span>
                                                    @elseif ($item->status == 'cancelled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->payment_status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @else
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.orders.invoice', $item->order_number) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fa fa-file"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
