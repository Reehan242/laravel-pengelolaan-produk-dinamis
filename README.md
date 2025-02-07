# Pengelolaan Produk Dinamis

Proyek ini adalah sistem pengelolaan produk dengan properti dinamis menggunakan Laravel, Bootstrap, dan MySQL.

## Persyaratan
- PHP >= 8.2
- Composer
- Laravel 11
- MySQL
- OS: Windows

## Instalasi & Konfigurasi
### Apabila Melalui Github Repositories
1. Clone repository 
2. Install dependency: `composer install`
3. Salin file `.env.example` menjadi `.env`: cp .env.example .env
4. Sesuaikan konfigurasi database di file `.env`:
5. Generate application key: php artisan key:generate
6. Jalankan migrasi: `php artisan migrate` apabila database sudah di konfigurasi

### Apabila Anda Mendapatkan Langsung Zip File Nya (Diluar dari Github)
1. Extract Zip
2. Sesuaikan konfigurasi database pada file `.env` sesuaikan dengan database yang ingin anda gunakan
3. Apabila menggunakan mysql, jalankan server mysql yang anda gunakan
4. Generate application key: php artisan key:generate
5. Jalankan `php artisan migrate` 

## Menjalankan Proyek
1. Jalankan server development: `php artisan serve`
   (akses via http://localhost:8000)
2. Uji API dengan Postman atau cURL sesuai endpoint di atas.
3. Akses tampilan web utama di http://localhost:8000 untuk melihat daftar produk  atau mengedit produk.

## Struktur Database
- Tabel **products**: id, name, description, created_at, updated_at.
- Tabel **product_properties**: id, product_id, property_name, property_value, created_at, updated_at.

Relasi: Setiap produk memiliki banyak properti (hasMany).

## API Endpoints

**Base URL:** `http://localhost:8000/api`

1. **GET /products**  
   Ambil daftar produk beserta data properti nya.

2. **GET /products/{id}**  
   Ambil detail produk tertentu (termasuk properti).

3. **POST /products**  
   Tambah produk baru (properties dan description opsional).  
   Contoh payload (JSON):
   ```
   {  
     "name": "Produk A",  
     "description": "Deskripsi Produk A",  
     "price" : 50000, 
     "properties": [  
       { "property_name": "Warna", "property_value": "Merah" },  
       { "property_name": "Ukuran", "property_value": "L" }  
     ]  
   }
   ```
4. **PUT /products/{productId}**  
   Ubah produk. 
   Contoh payload (JSON):
   ```
   {  
     "name": "Produk A",  
     "description": "Deskripsi Produk A",
     "price" : 50000,  
     "properties": [  
       { "property_name": "Warna", "property_value": "Biru" },  
       { "property_name": "Berat", "property_value": "400 Gram" }  
     ]  
   }
   ```

5. **PUT /products/{productId}/properties/{propertyId}**  
   Ubah properti produk.  
   Contoh payload (JSON):
   ```
   {  
     "property_name": "Warna",  
     "property_value": "Biru"  
   }
   ```

6. **DELETE /products/{productId}**  
   Hapus properti produk.

7. **DELETE /products/{productId}/properties/{propertyId}**  
   Hapus properti produk.


## Struktur Folder Utama Project
```

pengelolaan-produk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── API/
│   │   │   │   └── ProductController.php                            # Controller utama untuk Api
│   │   │   └── ProductViewController.php                            # Controller utama untuk tampilan web
│   ├── Models/
│   │   ├── Product.php                                              # Model Product
│   │   └── ProductProperty.php                                      # Model ProductProperty
├── database/
│   └── migrations/
│       ├── 2025_02_01_000000_create_products_table.php              # Migration untuk table products
│       └── 2025_02_01_000001_create_product_properties_table.php    # Migration untuk table product_properties
├── resources/
│   └── views/
│       └── products/
│           └── index.blade.php                                      # Tampilan utama web
├── routes/
│   ├── api.php                                                      # Route untuk API Endpoint
│   └── web.php                                                      # Route untuk website
└── .env                                                             # konfigurasi website 

```





