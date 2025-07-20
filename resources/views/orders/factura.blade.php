<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Pedido #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #222; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1a7f37; padding-bottom: 10px; }
        .logo { width: 140px; margin-bottom: 8px; }
        .empresa { font-size: 1.2rem; font-weight: bold; color: #1a7f37; margin-bottom: 2px; }
        .empresa-info { color: #555; font-size: 0.95rem; margin-bottom: 8px; }
        .title { font-size: 2rem; font-weight: bold; color: #1a7f37; margin-bottom: 2px; }
        .factura-info { margin: 20px 0 10px 0; }
        .info, .products { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info td { padding: 4px 8px; }
        .products th, .products td { border: 1px solid #ddd; padding: 8px; }
        .products th { background: #e5e7eb; color: #1a7f37; font-weight: bold; }
        .products tr:nth-child(even) { background: #f6f6f6; }
        .totals { width: 40%; float: right; margin-top: 20px; border-collapse: collapse; }
        .totals td { padding: 6px 12px; font-size: 1.1rem; }
        .totals .label { text-align: right; color: #555; }
        .totals .value { text-align: right; font-weight: bold; color: #1a7f37; }
        .footer { margin-top: 60px; text-align: center; color: #888; font-size: 12px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/Captura de pantalla_7-7-2025_184124_www.design.com.jpeg') }}" class="logo" alt="Logo">
        <div class="empresa">Artesanos Marketplace</div>
        <div class="empresa-info">www.chritzzu.net.registr | contacto@artesanos.com</div>
        <div class="title">Factura</div>
    </div>
    <div class="factura-info">
        <table class="info">
            <tr>
                <td><strong>N° Factura:</strong> #{{ $order->id }}</td>
                <td><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Cliente:</strong> {{ $order->user->name }}</td>
                <td><strong>Email:</strong> {{ $order->user->email }}</td>
            </tr>
        </table>
    </div>
    <table class="products">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach($order->products as $product)
                @php $linea = $product->pivot->cantidad * $product->pivot->precio; $subtotal += $linea; @endphp
                <tr>
                    <td>{{ $product->nombre }}</td>
                    <td>{{ $product->pivot->cantidad }}</td>
                    <td>${{ number_format($product->pivot->precio,2) }}</td>
                    <td>${{ number_format($linea,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="totals">
        <tr>
            <td class="label">Subtotal:</td>
            <td class="value">${{ number_format($subtotal,2) }}</td>
        </tr>
        <tr>
            <td class="label">Total:</td>
            <td class="value">${{ number_format($order->total,2) }}</td>
        </tr>
    </table>
    <div style="clear:both;"></div>
    <div class="footer">
        Gracias por su compra | Artesanos Marketplace<br>
        Esta factura es válida como comprobante de compra.<br>
        © {{ date('Y') }} Artesanos Marketplace
    </div>
</body>
</html> 