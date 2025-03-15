<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'description' => 'Default category for uncategorized items',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan',
                'slug' => 'food',
                'description' => 'Category for food items',
                'is_active' => true,
            ],
            [
                'name' => 'Minuman',
                'slug' => 'drink',
                'description' => 'Category for drink items',
                'is_active' => true,
            ],
            [
                'name' => 'Cemilan',
                'slug' => 'snack',
                'description' => 'Category for snack items',
                'is_active' => true,
            ],
        ]);
    }
}
