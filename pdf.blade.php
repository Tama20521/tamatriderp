<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', sans-serif; }
        body { font-size: 12px; color: #333; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #4f46e5; padding-bottom: 20px; margin-bottom: 25px; }
        .company-info h1 { font-size: 24px; color: #4f46e5; margin-bottom: 5px; }
        .company-info p { font-size: 11px; color: #666; line-height: 1.4; }
        .invoice-info { text-align: right; }
        .invoice-info .invoice-number { font-size: 20px; font-weight: bold; color: #4f46e5; margin-bottom: 5px; }
        .invoice-info p { font-size: 11px; color: #666; line-height: 1.6; }
        .invoice-info .status { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 10px; font-weight: bold; margin-top: 5px; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-partial { background: #fef3c7; color: #92400e; }
        .status-pending { background: #fee2e2; color: #991b1b; }
        .section-title { font-size: 13px; font-weight: bold; color: #4f46e5; margin-bottom: 10px; text-transform: uppercase; border-left: 4px solid #4f46e5; padding-left: 10px; }
        .client-info { background: #f9fafb; padding: 15px; border-radius: 8px; margin-bottom: 25px; }
        .client-info table { width: 100%; }
        .client-info td { padding: 3px 0; font-size: 12px; }
        .client-info td:first-child { color: #666; width: 120px; }
        .client-info td:last-child { font-weight: bold; color: #111; }
        .products-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .products-table thead { background: #4f46e5; color: white; }
        .products-table th { padding: 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        .products-table th.text-right { text-align: right; }
        .products-table tbody tr { border-bottom: 1px solid #e5e7eb; }
        .products-table tbody tr:nth-child(even) { background: #f9fafb; }
        .products-table td { padding: 10px; font-size: 12px; }
        .products-table td.text-right { text-align: right; }
        .totals { width: 300px; margin-left: auto; margin-top: 15px; }
        .totals table { width: 100%; }
        .totals td { padding: 8px; font-size: 12px; }
        .totals tr.total-row { background: #4f46e5; color: white; font-weight: bold; font-size: 14px; }
        .totals td:first-child { text-align: right; }
        .totals td:last-child { text-align: right; font-weight: bold; }
        .totals tr.balance-row td:last-child { color: #dc2626; }
        .totals tr.paid-row td:last-child { color: #059669; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 2px solid #e5e7eb; text-align: center; font-size: 10px; color: #999; }
        .footer .thanks { font-size: 13px; color: #4f46e5; font-weight: bold; margin-bottom: 8px; }
        .signature { margin-top: 50px; display: flex; justify-content: space-between; }
        .signature div { width: 45%; border-top: 1px solid #333; padding-top: 5px; text-align: center; font-size: 11px; color: #666; }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-info">
            <h1>TamaTrix ERP</h1>
            <p>
                <strong>TamaTechFinance</strong><br>
                Sistema de Gestión Empresarial<br>
                RNC: 1-01-12345-6<br>
                Email: info@tamatechfinance.com<br>
                Teléfono: +1 809-555-0000<br>
                Santo Domingo, República Dominicana
            </p>
        </div>
        <div class="invoice-info">
            <div class="invoice-number">
                FACTURA #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
            </div>
            <p>
                <strong>Fecha de emisión:</strong><br>
                {{ $sale->created_at->format('d/m/Y H:i') }}<br>
                @if($sale->payment_type === 'credito' && $sale->due_date)
                    <strong>Vence:</strong> {{ $sale->due_date->format('d/m/Y') }}<br>
                @endif
            </p>
            @if($sale->payment_status === 'paid')
                <span class="status status-paid">PAGADA</span>
            @elseif($sale->payment_status === 'partial')
                <span class="status status-partial">PAGO PARCIAL</span>
            @else
                <span class="status status-pending">PENDIENTE</span>
            @endif
        </div>
    </div>

    <div class="section-title">Datos del Cliente</div>
    <div class="client-info">
        <table>
            <tr>
                <td>Nombre:</td>
                <td>{{ $sale->client->name ?? 'Consumidor Final' }}</td>
            </tr>
            @if($sale->client)
                @if($sale->client->document)
                    <tr>
                        <td>Documento:</td>
                        <td>{{ $sale->client->document }}</td>
                    </tr>
                @endif
                @if($sale->client->email)
                    <tr>
                        <td>Email:</td>
                        <td>{{ $sale->client->email }}</td>
                    </tr>
                @endif
                @if($sale->client->phone)
                    <tr>
                        <td>Teléfono:</td>
                        <td>{{ $sale->client->phone }}</td>
                    </tr>
                @endif
                @if($sale->client->address)
                    <tr>
                        <td>Dirección:</td>
                        <td>{{ $sale->client->address }}</td>
                    </tr>
                @endif
            @endif
            <tr>
                <td>Tipo de Pago:</td>
                <td>{{ ucfirst($sale->payment_type) }}</td>
            </tr>
            <tr>
                <td>Vendedor:</td>
                <td>{{ $sale->user->name ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Detalle de Productos</div>
    <table class="products-table">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Producto</th>
                <th class="text-right" style="width: 80px;">Cantidad</th>
                <th class="text-right" style="width: 100px;">Precio Unit.</th>
                <th class="text-right" style="width: 110px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-right">{{ $product->pivot->quantity }}</td>
                    <td class="text-right">${{ number_format($product->price, 2) }}</td>
                    <td class="text-right">${{ number_format($product->pivot->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>${{ number_format($sale->total, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>TOTAL:</td>
                <td>${{ number_format($sale->total, 2) }}</td>
            </tr>
            @if($sale->payment_type === 'credito')
                <tr class="paid-row">
                    <td>Pagado:</td>
                    <td>${{ number_format($sale->paid_amount, 2) }}</td>
                </tr>
                <tr class="balance-row">
                    <td>Saldo Pendiente:</td>
                    <td>${{ number_format($sale->balance, 2) }}</td>
                </tr>
            @endif
        </table>
    </div>

    <div class="signature">
        <div>Firma del Cliente</div>
        <div>Firma del Vendedor</div>
    </div>

    <div class="footer">
        <div class="thanks">¡Gracias por su compra!</div>
        <p>
            Esta factura fue generada automáticamente por <strong>TamaTrix ERP</strong><br>
            © {{ date('Y') }} TamaTechFinance — Todos los derechos reservados<br>
            Documento generado el {{ now()->format('d/m/Y H:i:s') }}
        </p>
    </div>

</body>
</html>