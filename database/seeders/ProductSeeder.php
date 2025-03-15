<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Beras 5kg',
                'slug' => 'beras-5kg',
                'description' => 'Beras premium kemasan 5kg',
                'price' => 65000,
                'stock' => 20,
                'is_active' => true,
                'category_id' => 2,
            ],
            [
                'name' => 'Indomie Goreng',
                'slug' => 'indomie-goreng',
                'description' => 'Mie instan rasa goreng spesial',
                'price' => 3000,
                'stock' => 50,
                'is_active' => true,
                'category_id' => 2,
            ],
            [
                'name' => 'Sarden ABC 155g',
                'slug' => 'sarden-abc-155g',
                'description' => 'Sarden kaleng dengan saus tomat',
                'price' => 15000,
                'stock' => 15,
                'is_active' => true,
                'category_id' => 2,
            ],
            [
                'name' => 'Telur Ayam 1kg',
                'slug' => 'telur-ayam-1kg',
                'description' => 'Telur ayam kampung segar',
                'price' => 28000,
                'stock' => 30,
                'is_active' => true,
                'category_id' => 2,
            ],

            [
                'name' => 'Teh Botol Sosro 350ml',
                'slug' => 'teh-botol-sosro-350ml',
                'description' => 'Teh manis dalam kemasan botol',
                'price' => 5000,
                'stock' => 25,
                'is_active' => true,
                'category_id' => 3,
            ],
            [
                'name' => 'Kopi Kapal Api 65g',
                'slug' => 'kopi-kapal-api-65g',
                'description' => 'Kopi hitam bubuk khas Kapal Api',
                'price' => 7000,
                'stock' => 40,
                'is_active' => true,
                'category_id' => 3,
            ],
            [
                'name' => 'Aqua 600ml',
                'slug' => 'aqua-600ml',
                'description' => 'Air mineral dalam kemasan botol',
                'price' => 4000,
                'stock' => 60,
                'is_active' => true,
                'category_id' => 3,
            ],
            [
                'name' => 'Nutrisari Jeruk 15g',
                'slug' => 'nutrisari-jeruk-15g',
                'description' => 'Minuman serbuk rasa jeruk',
                'price' => 2000,
                'stock' => 50,
                'is_active' => true,
                'category_id' => 3,
            ],

            [
                'name' => 'Chitato Rasa Sapi Panggang 75g',
                'slug' => 'chitato-rasa-sapi-panggang-75g',
                'description' => 'Keripik kentang dengan bumbu sapi panggang',
                'price' => 12000,
                'stock' => 20,
                'is_active' => true,
                'category_id' => 4,
            ],
            [
                'name' => 'Taro Net Cheese 75g',
                'slug' => 'taro-net-cheese-75g',
                'description' => 'Snack jaring dengan rasa keju',
                'price' => 9000,
                'stock' => 15,
                'is_active' => true,
                'category_id' => 4,
            ],
            [
                'name' => 'Wafer Tango Coklat 130g',
                'slug' => 'wafer-tango-coklat-130g',
                'description' => 'Wafer renyah dengan rasa coklat',
                'price' => 13000,
                'stock' => 25,
                'is_active' => true,
                'category_id' => 4,
            ],
            [
                'name' => 'Kacang Garuda 100g',
                'slug' => 'kacang-garuda-100g',
                'description' => 'Kacang tanah goreng dengan kulit',
                'price' => 8000,
                'stock' => 30,
                'is_active' => true,
                'category_id' => 4,
            ],
        ]);
    }
}
