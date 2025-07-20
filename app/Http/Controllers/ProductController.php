<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);
        $data = $request->only('nombre', 'descripcion', 'precio', 'stock');
        $data['user_id'] = Auth::id();
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Producto creado');
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);
        $data = $request->only('nombre', 'descripcion', 'precio', 'stock');
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Producto actualizado');
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado');
    }

    public function catalogo(Request $request)
    {
        $query = Product::with('user')->latest();
        if ($request->filled('q')) {
            $query->where('nombre', 'like', '%'.$request->q.'%');
        }
        $products = $query->get();
        return view('products.catalogo', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('user');
        $puedeComprar = auth()->check() && auth()->user()->role === 'cliente';
        return view('products.show', compact('product', 'puedeComprar'));
    }

    private function authorizeProduct(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }
    }
} 