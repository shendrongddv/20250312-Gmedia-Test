# Aplikasi Kasir PT Warung Madura

Aplikasi kasir sederhana untuk PT Warung Madura yang dibangun menggunakan Laravel dan Vue.js.

## Tech Stack

- Laravel 10
- Vue 3 + Inertia.js
- Tailwind CSS
- MySQL
- Pinia (State Management)

## Fitur

- [x] Autentikasi (Login/Logout)
- [x] Manajemen Kategori (CRUD)
- [x] Manajemen Produk (CRUD)
- [x] Dashboard dengan Filter Produk
    - Filter berdasarkan nama produk
    - Filter berdasarkan kategori
- [x] Keranjang Belanja
    - Menambah produk ke keranjang
    - Mengubah jumlah produk
    - Menghapus produk dari keranjang
- [x] Transaksi Pembelian
    - Checkout dari keranjang
    - Riwayat transaksi
    - Detail transaksi

## Database Design

### Categories

- id (primary key)
- name
- slug
- description
- is_active
- created_at
- updated_at
- deleted_at

### Products

- id (primary key)
- category_id (foreign key)
- name
- slug
- description
- price
- stock
- is_active
- created_at
- updated_at
- deleted_at

### Transactions

- id (primary key)
- user_id (foreign key)
- total_amount
- status (enum: pending, completed, cancelled)
- notes
- created_at
- updated_at
- deleted_at

### Transaction Items

- id (primary key)
- transaction_id (foreign key)
- product_id (foreign key)
- product_name
- price
- quantity
- subtotal
- created_at
- updated_at

## State Management

Aplikasi ini menggunakan Pinia sebagai state management dengan 2 store utama:

### Cart Store

Mengelola state keranjang belanja:

- Daftar item di keranjang
- Total item
- Total harga
- Fungsi menambah item
- Fungsi mengubah quantity
- Fungsi menghapus item
- Fungsi mengosongkan keranjang

### Product Store

Mengelola state produk di dashboard:

- Daftar produk
- Filter pencarian
- Filter kategori
- Fungsi mengatur produk
- Fungsi mengatur filter

## Fungsi Pinia Cart

Cart Store (`stores/cart.js`) menyediakan fungsi-fungsi berikut:

### State

- `items`: Array yang berisi semua item di keranjang

### Getters

- `totalItems`: Menghitung total jumlah item di keranjang
- `totalPrice`: Menghitung total harga semua item di keranjang

### Actions

- `addItem(product)`: Menambahkan produk ke keranjang, dengan validasi stok
- `removeItem(productId)`: Menghapus item dari keranjang berdasarkan ID
- `increaseQuantity(productId)`: Menambah jumlah item, dengan validasi stok
- `decreaseQuantity(productId)`: Mengurangi jumlah item, menghapus jika quantity = 0
- `clearCart()`: Mengosongkan keranjang
- `saveToLocalStorage()`: Menyimpan keranjang ke localStorage

## Alur Transaksi

### 1. Pemilihan Produk (Dashboard)

- User melihat daftar produk di halaman Dashboard
- User dapat memfilter produk berdasarkan kategori atau pencarian
- User mengklik tombol "+" pada produk untuk menambahkan ke keranjang
- **Pinia Store**: `productStore` mengelola daftar dan filter produk, `cartStore.addItem()` dipanggil saat produk ditambahkan

### 2. Pengelolaan Keranjang

- User dapat melihat isi keranjang dengan mengklik tombol keranjang di navbar
- User dapat mengubah jumlah produk dengan tombol "+" dan "-"
- User dapat menghapus produk dari keranjang
- **Pinia Store**: `cartStore` mengelola semua operasi keranjang (`increaseQuantity()`, `decreaseQuantity()`, `removeItem()`)

### 3. Checkout (Halaman Cart)

- User mengklik tombol "Lihat Keranjang" untuk pergi ke halaman Cart
- Halaman Cart menampilkan daftar produk di keranjang dan total harga
- User mengklik tombol "Lanjutkan ke Pembayaran" untuk checkout
- **Pinia Store**: `cartStore` menyediakan data untuk halaman Cart

### 4. Proses Pembayaran

- Form checkout mengirimkan data keranjang ke server
- Server membuat transaksi baru dan item transaksi
- Server mengurangi stok produk
- **Pinia Store**: `cartStore.clearCart()` dipanggil setelah checkout berhasil

### 5. Konfirmasi Transaksi

- User diarahkan ke halaman sukses transaksi
- Halaman menampilkan detail transaksi dan total pembayaran
- User dapat kembali ke Dashboard untuk transaksi baru

### 6. Riwayat Transaksi

- User dapat melihat riwayat transaksi di halaman Transaksi
- User dapat melihat detail transaksi dengan mengklik transaksi

### Penyimpanan Data

- Data keranjang disimpan di localStorage untuk persistensi
- Data transaksi disimpan di database MySQL
- **Pinia Store**: `cartStore` menggunakan `watch` untuk menyimpan perubahan ke localStorage

## Instalasi

1. Clone repository

```bash
git clone https://github.com/shendrongddv/20250312-Gmedia-Test.git
```

2. Install dependencies

```bash
composer install
pnpm install
```

3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database

```bash
php artisan migrate --seed
```

5. Run server

```bash
php artisan serve
```

6. Run Vue

```bash
pnpm dev
```

## Login Default

Email: admin@gmail.com
Password: password
