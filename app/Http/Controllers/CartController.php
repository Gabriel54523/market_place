<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $products = $cart->products()->with('user')->get();
        return view('cart.index', compact('cart', 'products'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cantidad = (int) $request->input('cantidad', 1);
        if ($cantidad < 1) $cantidad = 1;
        // Validar stock disponible
        $enCarrito = $cart->products()->where('product_id', $product->id)->first();
        $yaEnCarrito = $enCarrito ? $enCarrito->pivot->cantidad : 0;
        if ($cantidad + $yaEnCarrito > $product->stock) {
            return redirect()->route('catalogo.show', $product)->with('error', 'No hay suficiente stock disponible');
        }
        $cart->products()->syncWithoutDetaching([
            $product->id => ['cantidad' => $cantidad + $yaEnCarrito]
        ]);
        return redirect()->route('carrito')->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cantidad = $request->input('cantidad', 1);
        if ($cantidad > 0) {
            $cart->products()->updateExistingPivot($product->id, ['cantidad' => $cantidad]);
        }
        return redirect()->route('carrito');
    }

    public function remove(Product $product)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->products()->detach($product->id);
        return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito');
    }
} 