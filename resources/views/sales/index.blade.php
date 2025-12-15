<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas - Zomard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow mb-8">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex gap-4 items-center">
                <div class="text-xl font-bold text-green-600">Zomard</div>
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-green-600 font-bold">📦 Productos</a>
                <a href="{{ route('clients.index') }}" class="text-gray-500 hover:text-green-600 font-bold">👥 Clientes</a>
                <a href="{{ route('sales.index') }}" class="text-green-600 border-b-2 border-green-600 font-bold">💰 Ventas</a>
            </div>
            
            <a href="{{ route('sales.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold">
                + Nueva Venta
            </a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Historial de Transacciones</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $sale->sale_date }} <br>
                            <span class="text-gray-400 text-xs">Folio #{{ $sale->id }}</span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 font-bold">{{ $sale->client->name }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="text-green-700 font-bold text-lg">Bs {{ number_format($sale->total, 2) }}</span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            @if($sale->status == 'pagado')
                                <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs font-bold">Pagado</span>
                            @else
                                <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs font-bold">Pendiente</span>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">
                                👁️ Ver Detalles
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($sales->isEmpty())
                <div class="p-10 text-center text-gray-500">
                    <p>Aún no has realizado ninguna venta.</p>
                </div>
            @endif
        </div>
    </div>

</body>
</html>