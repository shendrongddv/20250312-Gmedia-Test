<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->product->id),
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama produk wajib diisi',
            'name.unique' => 'Nama produk sudah digunakan',
            'price.required' => 'Harga produk wajib diisi',
            'price.numeric' => 'Harga produk harus berupa angka',
            'price.min' => 'Harga produk minimal 0',
            'stock.required' => 'Stok produk wajib diisi',
            'stock.integer' => 'Stok produk harus berupa angka',
            'stock.min' => 'Stok produk minimal 0',
            'category_id.required' => 'Kategori produk wajib dipilih',
            'category_id.exists' => 'Kategori produk tidak valid',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }

    protected function prepareForValidation()
    {
        // Handle special case for image removal
        if ($this->input('image') === 'remove') {
            $this->merge(['image' => 'remove']);
        }
    }
} 