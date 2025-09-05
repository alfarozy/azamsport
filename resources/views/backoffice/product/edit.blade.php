@extends('layouts.backoffice')
@section('title', 'Edit Product')

@section('style')
    <style>
        .ck-content {
            height: 575px
        }

        .img-preview {
            object-fit: cover;
            object-position: center;
            height: 200px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit @yield('title')</h1>
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

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="card-title mt-2">@yield('title')</h3>
                                <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm m-1">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>

                            <form method="POST" action="{{ route('product.update', $product->id) }}"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="row">
                                        <!-- Left Side -->
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" name="name"
                                                    value="{{ old('name', $product->name) }}"
                                                    class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control editor" rows="4">{{ old('description', $product->description) }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Right Side -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category_id" class="form-control select2bs4">
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $product->category_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Has Variant?</label>
                                                <select name="is_variant" id="is_variant" class="form-control">
                                                    <option value="0" {{ $product->is_variant ? '' : 'selected' }}>No
                                                    </option>
                                                    <option value="1" {{ $product->is_variant ? 'selected' : '' }}>Yes
                                                    </option>
                                                </select>
                                            </div>

                                            <div id="variant-wrapper"
                                                style="{{ $product->is_variant ? '' : 'display:none;' }}">
                                                <hr>
                                                <h5>Product Variants</h5>
                                                <div id="variant-container">
                                                    @forelse($product->variants as $i => $variant)
                                                        <div class="variant-item border rounded p-2 mb-2">
                                                            <div class="row g-2 align-items-end">
                                                                <div class="col-md-3">
                                                                    <input type="text"
                                                                        name="variants[{{ $i }}][name]"
                                                                        value="{{ $variant->name }}" class="form-control"
                                                                        placeholder="Variant Name">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number"
                                                                        name="variants[{{ $i }}][price]"
                                                                        value="{{ $variant->price }}" class="form-control"
                                                                        placeholder="Price (Rp)">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="number"
                                                                        name="variants[{{ $i }}][stock]"
                                                                        value="{{ $variant->stock }}" class="form-control"
                                                                        placeholder="Stock">
                                                                </div>
                                                                <div class="col-md-1 d-grid">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm remove-variant">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="variant-item border rounded p-2 mb-2">
                                                            <div class="row g-2 align-items-end">
                                                                <div class="col-md-3">
                                                                    <input type="text" name="variants[0][name]"
                                                                        class="form-control" placeholder="Variant Name">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" name="variants[0][price]"
                                                                        class="form-control" placeholder="Price (Rp)">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="number" name="variants[0][stock]"
                                                                        class="form-control" placeholder="Stock">
                                                                </div>
                                                                <div class="col-md-1 d-grid">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm remove-variant">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm mt-2"
                                                    id="add-variant">+ Add Variant</button>
                                            </div>

                                            <div class="form-group" id="price-group"
                                                style="{{ $product->is_variant ? 'display:none;' : '' }}">
                                                <label>Price (Rp)</label>
                                                <input type="number" name="price"
                                                    value="{{ old('price', $product->price) }}" class="form-control">
                                            </div>

                                            <div class="form-group" id="stock-group"
                                                style="{{ $product->is_variant ? 'display:none;' : '' }}">
                                                <label>Stock</label>
                                                <input type="number" name="stock"
                                                    value="{{ old('stock', $product->stock) }}" class="form-control">
                                            </div>


                                            <div class="form-group">
                                                <label>Unit</label>
                                                <select name="unit" class="form-control">
                                                    <option value="pcs"
                                                        {{ $product->unit == 'pcs' ? 'selected' : '' }}>
                                                        pcs</option>
                                                    <option value="set"
                                                        {{ $product->unit == 'set' ? 'selected' : '' }}>
                                                        set</option>
                                                    <option value="pasang"
                                                        {{ $product->unit == 'pasang' ? 'selected' : '' }}>pasang</option>
                                                    <option value="paket"
                                                        {{ $product->unit == 'paket' ? 'selected' : '' }}>paket</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Image</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image"
                                                        class="custom-file-input input-img" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        Image</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <img class="image-preview rounded img-preview"
                                                    src="{{ $product->image ? asset('storage/' . $product->image) : '/assets/img/no-image.jpg' }}"
                                                    alt="preview">
                                            </div>

                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="enabled" class="form-control">
                                                    <option value="1" {{ $product->enabled == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0" {{ $product->enabled == 0 ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success col-md-3 mx-2">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="/assets/js/ckeditor.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isVariant = document.getElementById("is_variant");
            const variantWrapper = document.getElementById("variant-wrapper");
            const variantContainer = document.getElementById("variant-container");
            const addVariantBtn = document.getElementById("add-variant");

            // Price & Stock default
            const priceField = document.querySelector('input[name="price"]').closest(".form-group");
            const stockField = document.querySelector('input[name="stock"]').closest(".form-group");

            // Hitung jumlah varian yang sudah ada di server
            let variantIndex = {{ $product->variants->count() ?? 0 }};

            // Toggle tampil/hidden varian + hide price/stock
            function toggleVariant() {
                if (isVariant.value == "1") {
                    variantWrapper.style.display = "block";
                    priceField.style.display = "none";
                    stockField.style.display = "none";
                } else {
                    variantWrapper.style.display = "none";
                    priceField.style.display = "block";
                    stockField.style.display = "block";
                }
            }

            // Jalankan saat awal load (misal saat edit data)
            toggleVariant();

            // Jalankan saat select berubah
            isVariant.addEventListener("change", toggleVariant);

            // Tambah varian baru
            addVariantBtn.addEventListener("click", function() {
                let variantItem = `
               <div class="variant-item border rounded p-2 mb-2">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <input type="text" name="variants[${variantIndex}][name]"
                            class="form-control" placeholder="Variant Name">
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="variants[${variantIndex}][price]"
                            class="form-control" placeholder="Price (Rp)">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="variants[${variantIndex}][stock]"
                            class="form-control" placeholder="Stock">
                    </div>
                    <div class="col-md-1 d-grid">
                         <button type="button" class="btn btn-danger btn-sm remove-variant">
                             <i class="fa fa-trash"></i>
                         </button>
                    </div>
                </div>
            </div>`;
                variantContainer.insertAdjacentHTML("beforeend", variantItem);
                variantIndex++;
            });

            // Remove varian (juga deteksi klik di ikon <i>)
            variantContainer.addEventListener("click", function(e) {
                if (e.target.closest(".remove-variant")) {
                    e.target.closest(".variant-item").remove();
                }
            });
        });
    </script>


    <script>
        ClassicEditor.create(document.querySelector('.editor'), {

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold', 'italic', 'bulletedList', 'numberedList', 'link',
                        '|',
                        'blockQuote',
                        'insertTable',
                        'imageInsert',
                        '|',
                        'code',
                        'codeBlock',
                        'htmlEmbed'
                    ]
                },
                language: 'id',
                licenseKey: '',



            })
            .then(editor => {
                window.editor = editor;




            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error(
                    'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
                );
                console.warn('Build id: hosofu6grpb-m75gatu85ah8');
                console.error(error);
            });
    </script>

@endsection
