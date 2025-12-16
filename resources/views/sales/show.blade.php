<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Venta #{{ $sale->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow-lg border-t-4 border-green-600">
        
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-4xl font-bold text-green-700">Zomard</h1>
                <p class="text-gray-500">Importadora de Sanitarios</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-700">Nota de Venta #{{ $sale->id }}</h2>
                <p class="text-gray-500">Fecha: {{ $sale->sale_date }}</p>
                <div class="mt-2">
                    @if($sale->status == 'pagado')
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold text-sm">PAGADO</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full font-bold text-sm">PENDIENTE</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="border-b border-gray-200 pb-4 mb-4">
            <h3 class="text-gray-600 uppercase text-xs font-bold tracking-wider mb-2">Cliente</h3>
            <p class="text-lg font-bold text-gray-800">{{ $sale->client->name }}</p>
            <p class="text-gray-600">NIT/CI: {{ $sale->client->ci_nit ?? 'S/N' }}</p>
            <p class="text-gray-600">Cel: {{ $sale->client->phone }}</p>
        </div>

        <table class="w-full mb-8">
            <thead>
                <tr class="border-b-2 border-gray-300">
                    <th class="text-left py-2 text-gray-600">Producto</th>
                    <th class="text-right py-2 text-gray-600">Precio Unit.</th>
                    <th class="text-center py-2 text-gray-600">Cant.</th>
                    <th class="text-right py-2 text-gray-600">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->details as $detail)
                <tr class="border-b border-gray-100">
                    <td class="py-3">
                        <span class="font-bold text-gray-700">{{ $detail->product->name }}</span>
                    </td>
                    <td class="text-right py-3">Bs {{ number_format($detail->price, 2) }}</td>
                    <td class="text-center py-3">{{ $detail->quantity }}</td>
                    <td class="text-right py-3 font-bold text-gray-700">
                        Bs {{ number_format($detail->price * $detail->quantity, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <div class="flex flex-col md:flex-row gap-8 mt-4 border-t pt-4">
            
            <div class="w-full md:w-1/2">
                <div class="flex justify-between mb-2 text-lg">
                    <span class="font-bold text-gray-600">Total Venta:</span>
                    <span class="font-bold text-gray-800">Bs {{ number_format($sale->total, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2 text-lg text-green-700">
                    <span class="font-bold">A cuenta (Pagado):</span>
                    <span class="font-bold">- Bs {{ number_format($sale->paid_amount, 2) }}</span>
                </div>
                <div class="flex justify-between border-t-2 border-gray-800 pt-2 text-2xl text-red-600">
                    <span class="font-bold">SALDO A PAGAR:</span>
                    <span class="font-bold">Bs {{ number_format($sale->due_amount, 2) }}</span>
                </div>
            </div>

            <div class="w-full md:w-1/2 bg-gray-50 p-4 rounded border border-gray-200 no-print">
                @if($sale->due_amount > 0)
                    <h3 class="font-bold text-gray-700 mb-3">💰 Registrar Nuevo Abono</h3>
                    
                    @if($errors->any())
                        <div class="bg-red-100 text-red-700 p-2 text-sm rounded mb-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('sales.add_payment', $sale->id) }}" method="POST" class="flex gap-2 items-end">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-gray-500">Fecha</label>
                            <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded text-sm">
                        </div>
                        <div class="flex-1">
                            <label class="text-xs font-bold text-gray-500">Monto (Bs)</label>
                            <input type="number" name="amount" step="0.01" max="{{ $sale->due_amount }}" class="w-full border p-2 rounded" placeholder="Ej: 500">
                        </div>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Abonar
                        </button>
                    </form>
                @else
                    <div class="h-full flex items-center justify-center bg-green-100 rounded text-green-800 font-bold text-xl border border-green-300">
                        ✅ ¡DEUDA CANCELADA!
                    </div>
                @endif
            </div>
        </div>
        </table>

        @if($sale->payments->count() > 0)
        <div class="mt-8">
            <h4 class="font-bold text-gray-600 mb-2">Historial de Abonos</h4>
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="bg-gray-100 uppercase">
                    <tr>
                        <th class="px-4 py-2 border">Fecha</th>
                        <th class="px-4 py-2 border">Monto Abonado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->payments as $payment)
                    <tr>
                        <td class="px-4 py-2 border">{{ $payment->payment_date }}</td>
                        <td class="px-4 py-2 border font-bold text-green-600">Bs {{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="flex justify-end gap-4 mt-8 no-print">
            <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded font-bold">Volver</a>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded font-bold">🖨️ Imprimir Estado</button>
        </div>

    </div>

</body>
</html>