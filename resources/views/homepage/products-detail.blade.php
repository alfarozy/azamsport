@extends('homepage')
@section('title', $product['name'])
@section('content')
    @php
        $price =
            $product->is_variant && $product->variants->count() ? $product->variants->first()->price : $product->price;

        $stock =
            $product->is_variant && $product->variants->count() ? $product->variants->first()->stock : $product->stock;
    @endphp

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
                                <span class="badge bg-{{ $stock > 0 ? 'success' : 'secondary' }}" id="productStock">
                                    {{ $stock > 0 ? 'Tersedia ' . $stock . ' ' . $product['unit'] : 'Habis' }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-primary mb-0" id="productPrice">
                                    Rp{{ number_format($price, 0, ',', '.') }}
                                    <span class="text-muted">/ {{ $product['unit'] }}</span>
                                </h4>
                            </div>

                            {{-- Kalau produk punya varian, tampilkan pilihan varian --}}
                            @if ($product->is_variant && $product->variants->count())
                                <div class="mb-4">
                                    <h5 class="fw-bold mb-2">Pilih Varian</h5>
                                    <div class="btn-group d-flex flex-wrap" role="group">
                                        @foreach ($product->variants as $variant)
                                            <input type="radio" class="btn-check" name="variant"
                                                id="variant-{{ $variant->id }}" value="{{ $variant->id }}"
                                                data-price="{{ $variant->price }}" data-stock="{{ $variant->stock }}">
                                            <label class="btn btn-outline-primary m-1" for="variant-{{ $variant->id }}">
                                                {{ $variant->name }} <br>
                                                <small>Rp{{ number_format($variant->price, 0, ',', '.') }}</small>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('variant_id')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            @endif
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
                                <p>{!! $product['description'] !!}</p>
                            </div>

                            <div class="border-top pt-3">
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#confirmModal">
                                    <i class="fas fa-shopping-cart me-2"></i> Sewa Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk lainnya --}}
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Produk Lainnya</h4>
                            <div class="row g-4">
                                @foreach ($relatedProducts as $related)
                                    @php
                                        $relatedPrice =
                                            $related->is_variant && $related->variants->count()
                                                ? $related->variants->first()->price
                                                : $related->price;
                                    @endphp
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <img src="{{ $related->getThumbnail() }}" class="card-img-top"
                                                alt="{{ $related['name'] }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $related['name'] }}</h5>
                                                <p class="text-primary mb-0">
                                                    Rp{{ number_format($relatedPrice, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div class="card-footer bg-white border-0">
                                                <a href="{{ route('homepage.products.detail', ['slug' => $related->slug]) }}"
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

    <!-- Modal Penyewaan -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('rental.store', $product->slug) }}" method="POST" id="rentalForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Penyewaan - {{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Kalau produk punya varian, kirim varian_id --}}
                        @if ($product->is_variant && $product->variants->count())
                            <input type="hidden" name="variant_id" id="variantInput"
                                value="{{ $product->variants->first()->id }}">
                        @endif

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

                        {{-- Alamat --}}
                        <div class="mb-3 d-none" id="addressGroup">
                            <label class="form-label">Alamat Pengantaran</label>
                            <textarea name="delivery_address" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Whatsapp</label>
                            <input type="text" name="rental_phone" id="rental_phone" class="form-control" required
                                placeholder="08123">
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="mb-3">
                            <label class="form-label">Pilih metode pembayaran</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="">-- Pilih Bank --</option>
                                <option value="bca">Bank BCA</option>
                                <option value="bni">Bank BNI</option>
                                <option value="mandiri">Bank Mandiri</option>
                                <option value="bri">Bank BRI</option>
                            </select>
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>

                        {{-- Total Biaya --}}
                        <div class="alert alert-primary">
                            <div class="d-flex justify-content-between">
                                <span>Total Pembayaran:</span>
                                <span id="totalCost" class="fw-bold">
                                    Rp{{ number_format($price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <small class="text-muted">Dengan melanjutkan, Anda menyetujui syarat & ketentuan penyewaan.</small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi Sewa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantRadios = document.querySelectorAll('input[name="variant"]');
            const priceEl = document.getElementById('productPrice');
            const stockEl = document.getElementById('productStock');

            if (variantRadios.length > 0) {
                variantRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const price = this.getAttribute('data-price');
                        const stock = this.getAttribute('data-stock');

                        // Update harga
                        priceEl.innerHTML = `Rp${new Intl.NumberFormat('id-ID').format(price)}
                        <span class="text-muted">/ {{ $product['unit'] }}</span>`;

                        // Update stok
                        if (stock > 0) {
                            stockEl.className = 'badge bg-success';
                            stockEl.innerText = 'Tersedia ' + stock + ' ' +
                                '{{ $product['unit'] }}';
                        } else {
                            stockEl.className = 'badge bg-secondary';
                            stockEl.innerText = 'Habis';
                        }
                    });
                });

                // Pilih default varian pertama
                variantRadios[0].checked = true;
                variantRadios[0].dispatchEvent(new Event('change'));
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantRadios = document.querySelectorAll('input[name="variant"]');
            const priceEl = document.getElementById('productPrice');
            const stockEl = document.getElementById('productStock');
            const variantInput = document.getElementById('variantInput');
            const quantityEl = document.getElementById('quantity');
            const startDateEl = document.getElementById('startDate');
            const endDateEl = document.getElementById('endDate');
            const deliveryEl = document.getElementById('delivery');
            const totalCostEl = document.getElementById('totalCost');

            let basePrice = parseInt({{ $price }});

            function getSelectedPrice() {
                let selected = document.querySelector('input[name="variant"]:checked');
                return selected ? parseInt(selected.dataset.price) : basePrice;
            }

            function calculateTotal() {
                let price = getSelectedPrice();
                let qty = parseInt(quantityEl.value) || 1;
                let deliveryFee = deliveryEl.value === 'delivery' ? 20000 : 0;

                let startDate = new Date(startDateEl.value);
                let endDate = new Date(endDateEl.value);
                let days = 1;
                if (startDate && endDate && endDate >= startDate) {
                    days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                }

                let total = (price * qty * days) + deliveryFee;
                totalCostEl.textContent = 'Rp' + total.toLocaleString('id-ID');
            }

            // Saat varian dipilih
            if (variantRadios.length > 0) {
                variantRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const price = parseInt(this.dataset.price);
                        const stock = parseInt(this.dataset.stock);

                        // Update hidden input varian
                        if (variantInput) {
                            variantInput.value = this.value;
                        }

                        // Update harga
                        priceEl.innerHTML = `Rp${new Intl.NumberFormat('id-ID').format(price)}
                        <span class="text-muted">/ {{ $product['unit'] }}</span>`;

                        // Update stok
                        if (stock > 0) {
                            stockEl.className = 'badge bg-success';
                            stockEl.innerText = 'Tersedia ' + stock + ' {{ $product['unit'] }}';
                        } else {
                            stockEl.className = 'badge bg-secondary';
                            stockEl.innerText = 'Habis';
                        }

                        calculateTotal();
                    });
                });

                // Pilih default varian pertama
                variantRadios[0].checked = true;
                variantRadios[0].dispatchEvent(new Event('change'));
            } else {
                calculateTotal();
            }

            // Event listener untuk total biaya
            [quantityEl, startDateEl, endDateEl, deliveryEl].forEach(el => {
                if (el) el.addEventListener('change', calculateTotal);
            });

            // Tampilkan alamat jika delivery dipilih
            deliveryEl.addEventListener('change', function() {
                const addressGroup = document.getElementById('addressGroup');
                if (this.value === 'delivery') {
                    addressGroup.classList.remove('d-none');
                } else {
                    addressGroup.classList.add('d-none');
                }
                calculateTotal();
            });

            // Set min date hari ini
            const today = new Date().toISOString().split('T')[0];
            startDateEl.min = today;
            endDateEl.min = today;

            calculateTotal();
        });
    </script>

@endsection
