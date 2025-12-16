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
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right py-4 font-bold text-xl text-gray-600">TOTAL:</td>
                    <td class="text-right py-4 font-bold text-xl text-green-700">
                        Bs {{ number_format($sale->total, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="flex justify-end gap-4 no-print items-center mt-8">
            
            <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-bold">
                Volver
            </a>

            @if($sale->status == 'pendiente')
                <form action="{{ route('sales.pay', $sale->id) }}" method="POST" onsubmit="return confirm('¿Confirmas que el cliente pagó el total de la deuda?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-bold flex items-center gap-2">
                        💸 Registrar Pago
                    </button>
                </form>
            @endif

            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold flex items-center gap-2">
                🖨️ Imprimir
            </button>
        </div>

    </div>

</body>
</html>