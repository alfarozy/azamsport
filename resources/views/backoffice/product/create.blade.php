@extends('layouts.backoffice')
@section('title', 'New Product')

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
                        <h1>Create @yield('title')</h1>
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
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title mt-2">@yield('title')</h3>
                                    <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm m-1">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>

                            <form method="POST" autocomplete="off" action="{{ route('product.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Left Side -->
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" name="name" value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control editor" rows="4">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Right Side -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category_id" class="form-control select2bs4"
                                                    style="width: 100%;">
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Has Variant?</label>
                                                <select name="is_variant" id="is_variant" class="form-control">
                                                    <option value="0" selected>No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>

                                            <div id="variant-wrapper" style="display: none;">
                                                <hr>
                                                <h5>Product Variants</h5>
                                                <div id="variant-container">
                                                    <div class="variant-item border rounded p-2 mb-2">
                                                        <div class="row g-2 align-items-end">
                                                            <div class="col-md-3">
                                                                <input type="text" name="variants[0][name]"
                                                                    class="form-control" placeholder="X">
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
                                                                    class="btn btn-danger btn-sm remove-variant"><i
                                                                        class="fa fa-trash"> </i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm mt-2"
                                                    id="add-variant">+ Add Variant</button>
                                            </div>


                                            <div class="form-group" id="price-group">
                                                <label>Price (Rp)</label>
                                                <input type="number" name="price" value="{{ old('price') }}"
                                                    class="form-control">
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group" id="stock-group">
                                                <label>Stock</label>
                                                <input type="number" name="stock" value="{{ old('stock') }}"
                                                    class="form-control">
                                                @error('stock')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Unit</label>
                                                <select name="unit" class="form-control">
                                                    <option value="" disabled selected>-- Select Unit --</option>
                                                    <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs
                                                    </option>
                                                    <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>set
                                                    </option>
                                                    <option value="pasang" {{ old('unit') == 'pasang' ? 'selected' : '' }}>
                                                        pasang</option>
                                                    <option value="paket" {{ old('unit') == 'paket' ? 'selected' : '' }}>
                                                        paket</option>
                                                </select>
                                                @error('unit')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Image</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image"
                                                        class="custom-file-input input-img" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        Image</label>
                                                </div>
                                                @error('image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <img class="image-preview rounded img-preview"
                                                    src="/assets/img/no-image.jpg" alt="preview">
                                            </div>

                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="enabled" class="form-control">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('enabled')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success col-md-3 mx-2">Submit</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isVariant = document.getElementById("is_variant");
            const variantWrapper = document.getElementById("variant-wrapper");
            const variantContainer = document.getElementById("variant-container");
            const addVariantBtn = document.getElementById("add-variant");

            // Price & Stock default
            const priceField = document.querySelector('input[name="price"]').closest(".form-group");
            const stockField = document.querySelector('input[name="stock"]').closest(".form-group");

            let variantIndex = 1;

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
                         <button type="button" class="btn btn-danger btn-sm remove-variant"><i
                                                                        class="fa fa-trash"> </i></button>
                    </div>
                </div>
            </div>

            `;
                variantContainer.insertAdjacentHTML("beforeend", variantItem);
                variantIndex++;
            });

            // Remove varian
            variantContainer.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-variant")) {
                    e.target.closest(".variant-item").remove();
                }
            });
        });
    </script>

    <script src="/assets/js/ckeditor.js"></script>

    <script>
        class MyUploadAdapter {
            constructor(loader) {
                // The file loader instance to use during the upload. It sounds scary but do not
                // worry — the loader will be passed into the adapter later on in this guide.
                this.loader = loader;
            }
            // Starts the upload process.
            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }
            // Aborts the upload process.
            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }
            // Initializes the XMLHttpRequest object using the URL passed to the constructor.
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                // Note that your request may look different. It is up to you and your editor
                // integration to choose the right communication channel. This example uses
                // a POST request with JSON as a data structure but your configuration
                // could be different.
                xhr.open('POST', '{{ route('ckeditor.uploadImage') }}', true);
                xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }
            // Initializes XMLHttpRequest listeners.
            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;
                    // This example assumes the XHR server's "response" object will come with
                    // an "error" which has its own "message" that can be passed to reject()
                    // in the upload promise.
                    //
                    // Your integration may handle upload errors in a different way so make sure
                    // it is done properly. The reject() function must be called when the upload fails.
                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }
                    // If the upload is successful, resolve the upload promise with an object containing
                    // at least the "default" URL, pointing to the image on the server.
                    // This URL will be used to display the image in the content. Learn more in the
                    // UploadAdapter#upload documentation.
                    resolve({
                        default: response.url
                    });
                });
                // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                // properties which are used e.g. to display the upload progress bar in the editor
                // user interface.
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }
            // Prepares the data and sends the request.
            _sendRequest(file) {
                // Prepare the form data.
                const data = new FormData();
                data.append('upload', file);
                // Important note: This is the right place to implement security mechanisms
                // like authentication and CSRF protection. For instance, you can use
                // XMLHttpRequest.setRequestHeader() to set the request headers containing
                // the CSRF token generated earlier by your application.
                // Send the request.
                this.xhr.send(data);
            }
            // ...
        }

        function SimpleUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };
        }

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

                extraPlugins: [SimpleUploadAdapterPlugin],

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
