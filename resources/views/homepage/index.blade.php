@extends('homepage')
@section('title', 'Sewa Alat Olahraga Praktis')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-white d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1 class="display-4 fw-bold mb-4">Sewa Alat Olahraga #TanpaRibet </h1>
                    <p class="lead mb-4">Akses peralatan olahraga berkualitas tinggi tanpa mengeluarkan biaya besar.
                        Kami yang urus perawatannya, Anda tinggal pakai dan nikmati!.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#produk" class="btn btn-light btn-lg fw-bold text-primary">Sewa Sekarang <i
                                class="fas fa-arrow-right ms-2"></i></a>
                        <a href="{{ route('homepage.products') }}" class="btn btn-outline-light btn-lg">Lihat Katalog</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Unggulan -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Kenapa Pilih AzimSport?</h2>
                <p class="text-muted">Solusi praktis untuk kebutuhan olahragamu</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Proses Cepat</h4>
                        <p class="text-muted">Pesan online dalam 3 menit, alat siap digunakan. Tidak perlu antri atau
                            datang ke toko.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="feature-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h4>Hemat Biaya</h4>
                        <p class="text-muted">Hanya bayar saat pakai. Mulai dari Rp15.000 saja, lebih hemat daripada
                            beli alat sendiri.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Terjamin Bersih</h4>
                        <p class="text-muted">Semua alat dibersihkan dan diperiksa setelah setiap pemakaian, higienis
                            dan nyaman.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Daftar Produk -->
    <section class="py-5 bg-light" id="produk">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Peralatan yang Tersedia</h2>
                <p class="text-muted">Sewa peralatan olahraga favoritmu dengan mudah</p>
            </div>

            <div class="row g-4">
                <!-- Produk 1 -->
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
                                        <span class="fw-bold text-primary">
                                            Rp{{ number_format($product['price'], 0, ',', '.') }}
                                        </span>
                                        <span class="text-muted small">/{{ $product['unit'] }}</span>
                                    </div>
                                    <span class="badge bg-{{ $product['stock'] > 0 ? 'success' : 'secondary' }}">
                                        {{ $product['stock'] > 0 ? 'Tersedia' : 'Habis' }}
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

            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary px-4">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>
    <!-- Cara Sewa - Alternatif 1 -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Cara Mudah Menyewa di AzimSport</h2>
                <p class="text-muted">Hanya 4 langkah sederhana untuk mendapatkan perlengkapan olahraga</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-center p-4 h-100">
                        <div class="step-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-search fa-2x"></i>
                        </div>
                        <h4 class="h5">1. Pilih Produk</h4>
                        <p class="text-muted small">Temukan peralatan yang Anda butuhkan di katalog kami</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text-center p-4 h-100">
                        <div class="step-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <h4 class="h5">2. Tentukan Jadwal</h4>
                        <p class="text-muted small">Pilih tanggal mulai dan akhir penyewaan</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text-center p-4 h-100">
                        <div class="step-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-credit-card fa-2x"></i>
                        </div>
                        <h4 class="h5">3. Bayar Online</h4>
                        <p class="text-muted small">Lakukan pembayaran secara digital dengan metode pilihan Anda</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text-center p-4 h-100">
                        <div class="step-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-truck fa-2x"></i>
                        </div>
                        <h4 class="h5">4. Ambil/Terima</h4>
                        <p class="text-muted small">Ambil di lokasi kami atau kami yang antar ke tempat Anda</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Testimonial -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Apa Kata Pelanggan Kami?</h2>
                <p class="text-muted">Testimoni dari mereka yang sudah mencoba layanan AzimSport</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm h-100 testimonial-card">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3"
                                width="50" height="50" alt="User">
                            <div>
                                <h6 class="mb-0">Andi Pratama</h6>
                                <small class="text-muted">Pegawai Kantoran</small>
                            </div>
                        </div>
                        <p>"Sangat praktis! Saya bisa sewa perlengkapan futsal untuk tim kantor tanpa harus beli.
                            Alatnya bersih dan harganya terjangkau."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm h-100 testimonial-card">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle me-3"
                                width="50" height="50" alt="User">
                            <div>
                                <h6 class="mb-0">Rina Wijaya</h6>
                                <small class="text-muted">Mahasiswi</small>
                            </div>
                        </div>
                        <p>"Awalnya ragu sewa sepatu lari, ternyata nyaman banget! Sekarang rutin jogging tiap minggu
                            pakai sewaan AzimSport."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm h-100 testimonial-card">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="rounded-circle me-3"
                                width="50" height="50" alt="User">
                            <div>
                                <h6 class="mb-0">Budi Santoso</h6>
                                <small class="text-muted">Komunitas Futsal</small>
                            </div>
                        </div>
                        <p>"Tim kami selalu sewa rompi dan bola di AzimSport untuk latihan. Proses cepat dan harganya
                            lebih murah daripada beli."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Sewa -->
    <section id="sewa" class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3">Siap Olahraga Tanpa Ribet?</h2>
                    <p class="lead mb-0">Daftar sekarang dan dapatkan diskon 20% untuk penyewaan pertama!</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="#" class="btn btn-light btn-lg fw-bold text-primary">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-muted">Temukan jawaban untuk pertanyaan umum tentang AzimSport</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne">
                                    Bagaimana cara menyewa peralatan di AzimSport?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Anda bisa menyewa peralatan dengan mudah melalui website kami:</p>
                                    <ol>
                                        <li>Pilih produk yang ingin disewa</li>
                                        <li>Tentukan durasi sewa</li>
                                        <li>Isi formulir pemesanan</li>
                                        <li>Lakukan pembayaran</li>
                                        <li>Ambil alat di lokasi kami atau gunakan layanan pengantaran</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo">
                                    Berapa lama durasi penyewaan?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Kami menyediakan beberapa pilihan durasi sewa:
                                    <ul>
                                        <li>Sewa harian (minimal 4 jam)</li>
                                        <li>Sewa mingguan (7 hari)</li>
                                        <li>Sewa event (khusus untuk acara/turnamen)</li>
                                    </ul>
                                    Durasi sewa bisa disesuaikan dengan kebutuhan Anda.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree">
                                    Apa saja metode pembayaran yang tersedia?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Kami menerima berbagai metode pembayaran untuk kenyamanan Anda:
                                    <ul>
                                        <li>Transfer bank (BCA, BRI, Mandiri, BNI)</li>
                                        <li>E-wallet (Dana, OVO, Gopay, ShopeePay)</li>
                                        <li>Cash on Delivery (COD) untuk wilayah tertentu di Kota Padang</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour">
                                    Bagaimana jika alat yang disewa rusak?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Kami memahami bahwa kerusakan bisa terjadi. Kebijakan kami:
                                    <ul>
                                        <li>Kerusakan normal karena pemakaian wajar tidak dikenakan biaya</li>
                                        <li>Untuk kerusakan berat karena kelalaian pengguna, akan dikenakan biaya
                                            perbaikan/penggantian sesuai harga pasar</li>
                                        <li>Sebelum menyewa, kami akan memfoto kondisi alat sebagai bukti</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1025&q=80"
                        class="img-fluid rounded shadow" alt="Tentang AzimSport">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Tentang AzimSport</h2>
                    <p>AzimSport adalah platform penyewaan peralatan olahraga yang
                        menyediakan solusi praktis untuk masyarakat yang ingin berolahraga tanpa harus membeli peralatan
                        sendiri.</p>
                    <p>Kami berfokus pada dua olahraga populer: mini soccer dan jogging, dengan menyediakan
                        perlengkapan lengkap dan berkualitas.</p>
                    <div class="mt-4">
                        <h5 class="fw-bold">Visi Kami</h5>
                        <p>Menjadi platform penyewaan peralatan olahraga terdepan di Indonesia yang mempermudah akses
                            masyarakat terhadap aktivitas olahraga secara praktis, efisien, dan terjangkau.</p>

                        <h5 class="fw-bold mt-4">Misi Kami</h5>
                        <ul>
                            <li>Menyediakan layanan penyewaan peralatan olahraga berbasis digital yang cepat, mudah, dan
                                terpercaya</li>
                            <li>Meningkatkan minat dan kemudahan masyarakat untuk berolahraga</li>
                            <li>Mendukung gaya hidup sehat di masyarakat urban Kota Padang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Hubungi Kami</h2>
                <p class="text-muted">Punya pertanyaan? Silakan hubungi tim AzimSport</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Lokasi</h4>
                        <p class="text-muted mb-0">Jl. Perintis Kemerdekaan No. 123<br>Kota Padang, Sumatera Barat</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="feature-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Telepon</h4>
                        <p class="text-muted mb-0">+62 812 3456 7890<br>Senin-Minggu, 08:00-20:00 WIB</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 bg-white rounded shadow-sm h-100">
                        <div class="feature-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email</h4>
                        <p class="text-muted mb-0">info@azimsport.com<br>cs@azimsport.com</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-6 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="card-title text-center mb-4">Kirim Pesan</h4>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" rows="4" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
