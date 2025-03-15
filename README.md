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

## Instalasi

1. Clone repository

```bash
git clone https://github.com/username/warung-madura.git
cd warung-madura
```

2. Install dependencies

```bash
composer install
npm install
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

Email: admin@example.com
Password: password
