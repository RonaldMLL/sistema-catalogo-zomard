<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Zomard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow mb-8">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-green-600">Zomard Admin</div>
            <div class="flex gap-4 font-bold text-gray-500">
                <a href="{{ route('dashboard') }}" class="text-green-600">🏠 Inicio</a>
                <a href="{{ route('products.index') }}" class="hover:text-green-600">📦 Productos</a>
                <a href="{{ route('clients.index') }}" class="hover:text-green-600">👥 Clientes</a>
                <a href="{{ route('sales.index') }}" class="hover:text-green-600">💰 Ventas</a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 pb-10">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Resumen del Negocio</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-green-100 p-6 rounded-lg border-l-4 border-green-500 shadow-sm">
                <p class="text-green-600 font-bold uppercase text-sm">Dinero en Caja</p>
                <p class="text-3xl font-bold text-green-800">Bs {{ number_format($dineroEnCaja, 2) }}</p>
            </div>

            <div class="bg-red-100 p-6 rounded-lg border-l-4 border-red-500 shadow-sm">
                <p class="text-red-600 font-bold uppercase text-sm">Cuentas por Cobrar</p>
                <p class="text-3xl font-bold text-red-800">Bs {{ number_format($porCobrar, 2) }}</p>
                <small class="text-red-600 font-bold">¡Hay dinero en la calle!</small>
            </div>

            <div class="bg-blue-100 p-6 rounded-lg border-l-4 border-blue-500 shadow-sm">
                <p class="text-blue-600 font-bold uppercase text-sm">Total Clientes</p>
                <p class="text-3xl font-bold text-blue-800">{{ $totalClientes }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white p-6 rounded shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">⚠️ Alertas de Stock Bajo</h3>
                
                @if($productosBajos->isEmpty())
                    <p class="text-green-600">¡Todo bien! Tienes suficiente stock.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($productosBajos as $prod)
                        <li class="flex justify-between items-center bg-orange-50 p-2 rounded">
                            <span class="font-bold text-gray-700">{{ $prod->name }}</span>
                            <span class="bg-orange-200 text-orange-800 px-2 py-1 rounded text-xs font-bold">
                                Quedan: {{ $prod->stock }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-white p-6 rounded shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">⏱️ Últimas Ventas</h3>
                <ul class="space-y-3">
                    @foreach($ultimasVentas as $sale)
                    <li class="flex justify-between items-center border-b border-gray-100 last:border-0 pb-2">
                        <div>
                            <span class="font-bold text-gray-700">{{ $sale->client->name }}</span>
                            <br>
                            <span class="text-xs text-gray-500">{{ $sale->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-right">
                            <span class="block font-bold">Bs {{ number_format($sale->total, 2) }}</span>
                            @if($sale->status == 'pendiente')
                                <span class="text-xs text-red-500 font-bold">Pendiente</span>
                            @else
                                <span class="text-xs text-green-500 font-bold">Pagado</span>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="mt-4 text-right">
                    <a href="{{ route('sales.index') }}" class="text-blue-600 text-sm font-bold hover:underline">Ver todas -></a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>