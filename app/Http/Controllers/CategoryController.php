<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        
        // Debugging
        \Log::info('Categories count: ' . $categories->count());
        \Log::info('Categories data: ' . json_encode($categories->items()));
        
        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'message' => session('message')
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store(StoreCategoryRequest $request)
    {
        // Generate slug from name
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        
        Category::create($data);

        return redirect()->route('categories.index')->with('message', 'Kategori berhasil dibuat');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Generate slug from name if name changed
        $data = $request->validated();
        if (isset($data['name']) && $data['name'] !== $category->name) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        $category->update($data);

        return redirect()->route('categories.index')->with('message', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('message', 'Kategori berhasil dihapus');
    }
}
