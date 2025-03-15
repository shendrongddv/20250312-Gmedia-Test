<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Dashboard', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
} 