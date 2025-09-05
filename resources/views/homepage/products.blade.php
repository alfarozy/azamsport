@extends('homepage')
@section('title', 'Katalog Alat Olahraga')
@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold">Katalog Peralatan Olahraga</h2>

                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('homepage.products', ['category' => 'all']) }}">Semua
                                Kategori</a></li>
                        @foreach ($categories as $cat)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('homepage.products', ['category' => $cat->name]) }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @if (session()->has('success'))
                <div class="alert bg-success text-center text-white">
                    {!! session()->get('success') !!}
                </div>
            @endif

            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ $product->getThumbnail() }}" class="card-img-top" alt="{{ $product['name'] }}">
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $product['name'] }}</h5>
                                </div>
                                <p class="text-muted small">{{ $product->category->name }}</p>

                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        @if ($product->is_variant && $product->variants->count() > 0)
                                            @php
                                                $minPrice = $product->variants->min('price');
                                                $maxPrice = $product->variants->max('price');
                                                $totalStock = $product->variants->sum('stock');
                                            @endphp
                                            <span class="fw-bold text-primary">
                                                Rp{{ number_format($minPrice, 0, ',', '.') }}
                                                @if ($minPrice != $maxPrice)
                                                    - Rp{{ number_format($maxPrice, 0, ',', '.') }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="fw-bold text-primary">
                                                Rp{{ number_format($product['price'], 0, ',', '.') }}
                                            </span>
                                            <span class="text-muted small">/{{ $product['unit'] }}</span>
                                            @php $totalStock = $product->stock; @endphp
                                        @endif
                                    </div>
                                    <span class="badge bg-{{ $totalStock > 0 ? 'success' : 'secondary' }}">
                                        {{ $totalStock > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="{{ route('homepage.products.detail', ['slug' => $product->slug]) }}"
                                    class="btn btn-primary w-100">
                                    Detail Produk
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {{ $products->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var rentModal = document.getElementById('rentModal');
            rentModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var productId = button.getAttribute('data-product-id');
                var productName = button.getAttribute('data-product-name');
                var productPrice = button.getAttribute('data-product-price');

                document.getElementById('productId').value = productId;
                document.getElementById('productName').textContent = productName;
                document.getElementById('productPrice').textContent = 'Rp' + parseInt(productPrice)
                    .toLocaleString('id-ID') + ' per item';
            });

            // Hitung total biaya saat input berubah
            var inputs = ['startDate', 'endDate', 'quantity', 'deliveryOption'];
            inputs.forEach(function(id) {
                document.getElementById(id).addEventListener('change', calculateTotal);
            });

            function calculateTotal() {
                var price = parseInt(document.getElementById('productPrice').textContent.replace(/\D/g, '')) || 0;
                var quantity = parseInt(document.getElementById('quantity').value) || 0;
                var startDate = new Date(document.getElementById('startDate').value);
                var endDate = new Date(document.getElementById('endDate').value);

                var days = 1;
                if (startDate && endDate) {
                    days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                }

                var deliveryCost = document.getElementById('deliveryOption').value === 'delivery' ? 20000 : 0;
                var total = (price * quantity * days) + deliveryCost;

                document.getElementById('totalCost').textContent = 'Rp' + total.toLocaleString('id-ID');
            }
        });
    </script>
@endsection
