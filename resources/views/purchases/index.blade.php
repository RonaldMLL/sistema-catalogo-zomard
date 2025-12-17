<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📦 Entradas de Almacén</h1>
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded font-bold">Volver</a>
                <a href="{{ route('purchases.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">+ Registrar Entrada</a>
            </div>
        </div>

        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-200 text-gray-700 uppercase">
                    <tr>
                        <th class="p-3">Fecha</th>
                        <th class="p-3">Producto</th>
                        <th class="p-3">Proveedor</th>
                        <th class="p-3 text-right">Cant.</th>
                        <th class="p-3 text-right">Costo Unit.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $purchase->purchase_date }}</td>
                        <td class="p-3 font-bold">{{ $purchase->product->name }}</td>
                        <td class="p-3 text-sm text-gray-600">{{ $purchase->provider->name }}</td>
                        <td class="p-3 text-right text-blue-600 font-bold">+{{ $purchase->quantity }}</td>
                        <td class="p-3 text-right">Bs {{ number_format($purchase->unit_cost, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</body>
</html>