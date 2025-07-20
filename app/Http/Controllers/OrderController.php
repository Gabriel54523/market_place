<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío');
        }
        // Validar stock de todos los productos
        foreach ($cart->products as $product) {
            if ($product->pivot->cantidad > $product->stock) {
                return redirect()->route('carrito')->with('error', 'No hay suficiente stock para el producto: ' . $product->nombre);
            }
        }
        $total = 0;
        foreach ($cart->products as $product) {
            $total += $product->precio * $product->pivot->cantidad;
        }
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'estado' => 'pendiente',
        ]);
        foreach ($cart->products as $product) {
            $order->products()->attach($product->id, [
                'cantidad' => $product->pivot->cantidad,
                'precio' => $product->precio,
            ]);
            // Descontar stock
            $product->stock -= $product->pivot->cantidad;
            $product->save();
        }
        $cart->products()->detach(); // Vaciar carrito
        return redirect()->route('pedidos')->with('success', 'Pedido realizado con éxito');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('products')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function artesanoPedidos()
    {
        $user = Auth::user();
        if ($user->role !== 'artesano') {
            abort(403, 'Solo los artesanos pueden ver esta página');
        }
        // Obtener los productos del artesano
        $productosIds = $user->products()->pluck('id');
        // Obtener los pedidos que contienen esos productos
        $orders = \App\Models\Order::whereHas('products', function($q) use ($productosIds) {
            $q->whereIn('product_id', $productosIds);
        })->with(['products' => function($q) use ($productosIds) {
            $q->whereIn('products.id', $productosIds);
        }, 'user'])->latest()->get();
        return view('orders.artesano', compact('orders'));
    }

    public function updateEstado(Request $request, Order $order)
    {
        $user = Auth::user();
        if ($user->role !== 'artesano') {
            abort(403, 'Solo los artesanos pueden cambiar el estado');
        }
        $request->validate([
            'estado' => 'required|in:pendiente,enviado,entregado',
        ]);
        $order->estado = $request->estado;
        $order->save();
        return redirect()->route('pedidos.artesano')->with('success', 'Estado del pedido actualizado');
    }

    public function facturaPDF(Order $order)
    {
        $order->load(['products', 'user']);
        $pdf = Pdf::loadView('orders.factura', compact('order'));
        $filename = 'factura_pedido_'.$order->id.'.pdf';
        return $pdf->download($filename);
    }
} 