<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Listar productos
    public function index()
    {
        return response()->json(Product::all());
    }

    // Crear producto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
        ]);
        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // Actualizar producto
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
        ]);
        $product->update($validated);
        return response()->json($product);
    }

    // Eliminar producto
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => true]);
    }
}
