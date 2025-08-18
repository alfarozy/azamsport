    @extends('homepage')
    @section('title', $product['name'])
    @section('content')
        <section class="py-5">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="#">Katalog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->category->name }}</li>
                    </ol>
                </nav>

                <div class="row g-5">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <img src="{{ $product->getThumbnail() }}" class="img-fluid rounded"
                                    alt="{{ $product['name'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h2 class="fw-bold mb-1">{{ $product['name'] }}</h2>
                                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                                    </div>
                                    <span class="badge bg-{{ $product['stock'] > 0 ? 'success' : 'secondary' }}">
                                        {{ $product['stock'] > 0 ? 'Tersedia ' . $product['stock'] . ' ' . $product['unit'] : 'Habis' }}
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-primary mb-0">Rp{{ number_format($product['price'], 0, ',', '.') }}
                                        <span class="text-muted">/ {{ $product['unit'] }}</span>
                                    </h4>
                                </div>

                                <div class="mb-4">
                                    <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
                                    <p>{!! $product['description'] !!}</p>
                                </div>

                                <div class="border-top pt-3">
                                    <button type="button" class="btn btn-primary w-100 py-3" data-bs-toggle="modal"
                                        data-bs-target="#confirmModal">
                                        <i class="fas fa-shopping-cart me-2"></i> Sewa Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4">Produk Lainnya</h4>
                                <div class="row g-4">
                                    @foreach ($relatedProducts as $related)
                                        <div class="col-md-6 col-lg-3">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <img src="{{ $related->getThumbnail() }}" class="card-img-top"
                                                    alt="{{ $related['name'] }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $related['name'] }}</h5>
                                                    <p class="text-primary mb-0">
                                                        Rp{{ number_format($related['price'], 0, ',', '.') }}</p>
                                                </div>
                                                <div class="card-footer bg-white border-0">
                                                    <a href="/product/{{ $related['id'] }}"
                                                        class="btn btn-outline-primary w-100">Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Konfirmasi -->
        <!-- Modal Penyewaan -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('rental.store') }}" method="POST" id="rentalForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Form Penyewaan - {{ $product->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Jumlah --}}
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1"
                                    min="1" required>
                            </div>

                            {{-- Tanggal Mulai & Selesai --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="startDate" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Kembali</label>
                                    <input type="date" name="end_date" id="endDate" class="form-control" required>
                                </div>
                            </div>

                            {{-- Metode Pengiriman --}}
                            <div class="mb-3">
                                <label class="form-label">Metode Pengambilan</label>
                                <select name="delivery_option" id="delivery" class="form-select" required>
                                    <option value="pickup">Ambil Sendiri</option>
                                    <option value="delivery">Diantar (+Rp20.000)</option>
                                </select>
                            </div>

                            {{-- Alamat (opsional jika delivery) --}}
                            <div class="mb-3 d-none" id="addressGroup">
                                <label class="form-label">Alamat Pengantaran</label>
                                <textarea name="delivery_address" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- Catatan --}}
                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- Total Biaya --}}
                            <div class="alert alert-primary">
                                <div class="d-flex justify-content-between">
                                    <span>Total Pembayaran:</span>
                                    <span id="totalCost" class="fw-bold">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <small class="text-muted">Dengan melanjutkan, Anda menyetujui syarat & ketentuan
                                penyewaan.</small>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Konfirmasi Sewa</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function calculateTotal() {
                    const price = {{ $product->price }};
                    const quantity = parseInt(document.getElementById('quantity').value) || 1;
                    const startDate = new Date(document.getElementById('startDate').value);
                    const endDate = new Date(document.getElementById('endDate').value);
                    const delivery = document.getElementById('delivery').value;

                    let days = 1;
                    if (startDate && endDate && endDate >= startDate) {
                        days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                    }

                    const deliveryCost = delivery === 'delivery' ? 20000 : 0;
                    const total = (price * quantity * days) + deliveryCost;

                    document.getElementById('totalCost').textContent = 'Rp' + total.toLocaleString('id-ID');
                }

                // Event listener untuk update biaya
                ['quantity', 'startDate', 'endDate', 'delivery'].forEach(id => {
                    document.getElementById(id).addEventListener('change', calculateTotal);
                });

                // Tampilkan alamat jika delivery dipilih
                document.getElementById('delivery').addEventListener('change', function() {
                    if (this.value === 'delivery') {
                        document.getElementById('addressGroup').classList.remove('d-none');
                    } else {
                        document.getElementById('addressGroup').classList.add('d-none');
                    }
                    calculateTotal();
                });

                // Set min date hari ini
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('startDate').min = today;
                document.getElementById('endDate').min = today;

                calculateTotal();
            });
        </script>
    @endsection
