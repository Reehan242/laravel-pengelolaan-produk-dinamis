<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Produk</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="/" class="navbar-brand">Product Warehouse</a>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <div class="container mt-3">
        <h1 class="text-center mb-3">Daftar Produk</h1>
        <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Tambah
            Produk</a>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <h6 class="card-subtitle text-body-secondary mb-2">Rp {{ $product->price }}</h6>
                            <p class="card-text">{{ $product->description }}</p>
                            @if ($product->properties->count())
                                <ul class="list-group">
                                    @foreach ($product->properties as $prop)
                                        <li class="list-group-item">
                                            <strong>{{ $prop->property_name }}:</strong> {{ $prop->property_value }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-warning edit-product-btn"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                data-product-description="{{ $product->description }}"
                                data-product-price="{{ $product->price }}"
                                data-product-properties='@json($product->properties)'>
                                Edit Product
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Modal Form Tambah Produk  --}}
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="addProductForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" step="1" name="price">
                        </div>

                        {{-- Container untuk properti dinamis  --}}
                        <div id="propertiesContainer">
                            <h6>Properti Dinamis</h6>
                            <div class="property-item mb-2">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="properties[0][property_name]" class="form-control"
                                            placeholder="Nama Properti">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="properties[0][property_value]" class="form-control"
                                            placeholder="Nilai Properti">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger remove-property">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addPropertyBtn" class="btn btn-secondary btn-sm">Tambah
                            Properti</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Product  --}}
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <form id="editProductForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" id="editProductDescription" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="editProductPrice" step="1"
                                name="price">
                        </div>

                        <h6>Properti Produk</h6>
                        <div id="editPropertiesContainer">
                            {{-- Properti-properti akan dimuat di sini --}}
                        </div>
                        <button type="button" id="addEditPropertyBtn" class="btn btn-secondary btn-sm mt-2">Tambah
                            Properti</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{--  Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- jQuery (untuk memudahkan manipulasi DOM)  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Script untuk form dan ajax pada edit dan create --}}
    <script>
        // Menambahkan baris properti dinamis
        $(document).on('click', '#addPropertyBtn', function() {
            let index = $('#propertiesContainer .property-item').length;
            let html = `<div class="property-item mb-2">
                    <div class="row">
                        <div class="col">
                            <input type="text" name="properties[${index}][property_name]" class="form-control" placeholder="Nama Properti">
                        </div>
                        <div class="col">
                            <input type="text" name="properties[${index}][property_value]" class="form-control" placeholder="Nilai Properti">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-property">Hapus</button>
                        </div>
                    </div>
                </div>`;
            $('#propertiesContainer').append(html);
        });

        // Menghapus baris properti dinamis
        $(document).on('click', '.remove-property', function() {
            $(this).closest('.property-item').remove();
        });

        // AJAX untuk submit form tambah produk
        $('#addProductForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serializeArray();
            $.ajax({
                url: '/api/products',
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Produk berhasil ditambahkan');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan. Periksa input data!');
                }
            });
        });

        // Ketika tombol "Edit Product" diklik
        $(document).on('click', '.edit-product-btn', function() {
            // data pada button edit yang dikirim di assign ke variable
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productDescription = $(this).data('product-description');
            var productPrice = $(this).data('product-price');
            var productProperties = $(this).data('product-properties'); // Array properti

            // Assign value modal edit pake data variable yang sudah di definisikan 
            $('#editProductId').val(productId);
            $('#editProductName').val(productName);
            $('#editProductDescription').val(productDescription);
            $('#editProductPrice').val(productPrice);

            // Bersihkan container properti sebelumnya
            $('#editPropertiesContainer').empty();

            if (productProperties && productProperties.length > 0) {
                // Untuk mengisi kontainer dari properties list
                $.each(productProperties, function(index, prop) {
                    var html = '<div class="property-item mb-2" data-property-id="' + prop.id + '">' +
                        '<div class="row">' +
                        '<div class="col">' +
                        '<input type="text" name="properties[' + index +
                        '][property_name]" class="form-control" value="' + prop.property_name +
                        '" required>' +
                        '<input type="hidden" name="properties[' + index + '][id]" value="' + prop.id +
                        '">' +
                        '</div>' +
                        '<div class="col">' +
                        '<input type="text" name="properties[' + index +
                        '][property_value]" class="form-control" value="' + prop.property_value +
                        '" required>' +
                        '</div>' +
                        '<div class="col-auto">' +
                        '<button type="button" class="btn btn-danger remove-property-btn">Hapus</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $('#editPropertiesContainer').append(html);
                });
            }

            // Tampilkan modal edit
            var editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        });

        // Tambah properti baru pada modal edit produk
        $(document).on('click', '#addEditPropertyBtn', function() {
            var index = $('#editPropertiesContainer .property-item').length;
            var html = '<div class="property-item mb-2">' +
                '<div class="row">' +
                '<div class="col">' +
                '<input type="text" name="properties[' + index +
                '][property_name]" class="form-control" placeholder="Nama Properti" required>' +
                '</div>' +
                '<div class="col">' +
                '<input type="text" name="properties[' + index +
                '][property_value]" class="form-control" placeholder="Nilai Properti" required>' +
                '</div>' +
                '<div class="col-auto">' +
                '<button type="button" class="btn btn-danger remove-property-btn">Hapus</button>' +
                '</div>' +
                '</div>' +
                '</div>';
            $('#editPropertiesContainer').append(html);
        });

        // Hapus properti dari modal edit produk
        $(document).on('click', '.remove-property-btn', function() {
            $(this).closest('.property-item').remove();
        });

        // Handle submit form edit produk
        $('#editProductForm').submit(function(e) {
            e.preventDefault();
            var productId = $('#editProductId').val();
            var formData = $(this).serialize();
            $.ajax({
                url: '/api/products/' + productId,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    alert('Produk berhasil diupdate');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal mengupdate produk');
                }
            });
        });
    </script>
</body>

</html>
