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
                                                <label>Price (Rp)</label>
                                                <input type="number" name="price"
                                                    value="{{ old('price', $product->price) }}" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" name="stock"
                                                    value="{{ old('stock', $product->stock) }}" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Unit</label>
                                                <select name="unit" class="form-control">
                                                    <option value="pcs" {{ $product->unit == 'pcs' ? 'selected' : '' }}>
                                                        pcs</option>
                                                    <option value="set" {{ $product->unit == 'set' ? 'selected' : '' }}>
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
                                                    <input type="file" name="image" class="custom-file-input input-img"
                                                        id="exampleInputFile">
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
