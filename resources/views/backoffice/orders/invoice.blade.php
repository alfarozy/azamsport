@extends('layouts.backoffice')
@section('title', 'Invoice Order #' . $order->order_number)

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice @yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.orders.index') }}">Orders</a></li>
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
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title">Detail Invoice</h3>
                            </div>
                            <div class="card-body">
                                @if (session()->has('success'))
                                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                                @endif

                                <table class="table table-bordered">
                                    <tr>
                                        <th width="25%">Order Number</th>
                                        <td><b>{{ $order->order_number }}</b></td>
                                    </tr>
                                    <tr>
                                        <th>Pengguna</th>
                                        <td>{{ $order->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $order->user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>{{ $order->rental_phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Produk</th>
                                        <td>{{ $order->product->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah</th>
                                        <td>{{ $order->quantity }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Sewa</th>
                                        <td>{{ date('d M Y', strtotime($order->start_date)) }} -
                                            {{ date('d M Y', strtotime($order->end_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Harga</th>
                                        <td><b>Rp{{ number_format($order->total_price, 0, ',', '.') }}</b></td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>{{ $order->note ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($order->status == 'confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif ($order->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>
                                            @if ($order->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif ($order->payment_status == 'waiting_confirmation')
                                                <span class="badge bg-info">Menunggu Konfirmasi</span>
                                            @else
                                                <span class="badge bg-danger">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                @if ($order->status == 'pending' && $order->payment_status != 'waiting_confirmation')
                                    <div class="alert alert-info mt-4">
                                        <h5>Instruksi Pembayaran</h5>

                                        @if ($order->payment_method == 'bca')
                                            <p>Silakan transfer ke rekening berikut:</p>
                                            <ul>
                                                <li><b>BCA</b> - 123456789 a.n Imran Syafri Yuldi</li>
                                            </ul>
                                        @elseif($order->payment_method == 'bni')
                                            <p>Silakan transfer ke rekening berikut:</p>
                                            <ul>
                                                <li><b>BNI</b> - 555555555 a.n Imran Syafri Yuldi</li>
                                            </ul>
                                        @elseif($order->payment_method == 'mandiri')
                                            <p>Silakan transfer ke rekening berikut:</p>
                                            <ul>
                                                <li><b>Mandiri</b> - 987654321 a.n Imran Syafri Yuldi</li>
                                            </ul>
                                        @elseif($order->payment_method == 'bri')
                                            <p>Silakan transfer ke rekening berikut:</p>
                                            <ul>
                                                <li><b>BRI</b> - 5481 0103 1261 531 a.n Imran Syafri Yuldi</li>
                                            </ul>
                                        @else
                                            <p><i>Belum memilih metode pembayaran</i></p>
                                        @endif

                                        <p>Setelah transfer, silakan upload bukti pembayaran di bawah.</p>
                                    </div>

                                    <form action="{{ route('user.orders.uploadPaymentProof', $order->id) }}" method="POST"
                                        enctype="multipart/form-data" class="mt-3">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                                            <input type="file" class="form-control" name="payment_proof" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-upload"></i> Upload
                                        </button>
                                    </form>
                                @endif

                                @if ($order->payment_status == 'waiting_confirmation')
                                    @if (auth()->user()->role == 'admin')
                                        {{-- Jika ada bukti pembayaran --}}
                                        @if ($order->payment_proof)
                                            <div class="mt-4">
                                                <h5>Bukti Pembayaran</h5>
                                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                                        alt="Bukti Pembayaran" class="img-fluid img-thumbnail"
                                                        style="max-width: 400px;">
                                                </a>
                                            </div>
                                        @endif
                                        <div class="alert alert-warning mt-4">
                                            Bukti pembayaran sudah dikirim user.
                                            Silakan konfirmasi pembayaran.
                                        </div>

                                        <form action="{{ route('admin.orders.confirmPayment', $order->id) }}"
                                            method="POST" class="mt-3">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="approve" class="btn btn-success">
                                                <i class="fa fa-check"></i> Setujui Pembayaran
                                            </button>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger">
                                                <i class="fa fa-times"></i> Tolak Pembayaran
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-secondary mt-4">
                                            Bukti pembayaran sudah dikirim. Menunggu konfirmasi admin.
                                            <p>Jika ada kendala atau ingin konfirmasi lebih cepat, silakan hubungi admin di:
                                                <br>
                                                <a href="https://wa.me/6282286456213" target="_blank">+6282286456213</a>
                                            </p>
                                        </div>
                                    @endif
                                @elseif($order->payment_status == 'paid')
                                    {{-- Tombol Pengembalian Produk --}}
                                    @if ($order->status == 'confirmed' && auth()->user()->role == 'admin')
                                        <div class="alert alert-info mt-4">
                                            Produk sudah disetujui dan sedang dipakai.
                                            Silakan klik tombol berikut jika produk sudah dikembalikan.
                                        </div>

                                        <form action="{{ route('admin.orders.confirmPayment', $order->id) }}"
                                            method="POST" class="mt-3">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="return" class="btn btn-warning">
                                                <i class="fa fa-undo"></i> Tandai Produk Dikembalikan
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-success mt-4">
                                            Bukti pembayaran sudah dikirim. Produk sudah disetujui dan sedang dipakai.
                                        </div>
                                    @endif
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
