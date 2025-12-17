<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Entrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow border-t-4 border-blue-600">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">📦 Registrar Entrada de Mercadería</h2>

        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-bold text-gray-700">Proveedor (Fábrica):</label>
                <select name="provider_id" class="w-full border p-2 rounded" required>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700">Producto:</label>
                <select name="product_id" class="w-full border p-2 rounded" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} (Stock actual: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block font-bold text-gray-700">Cantidad a Ingresar:</label>
                    <input type="number" name="quantity" class="w-full border p-2 rounded bg-blue-50" placeholder="Ej: 100" required>
                </div>

                <div class="w-1/2">
                    <label class="block font-bold text-gray-700">Costo Unitario (Bs):</label>
                    <input type="number" step="0.01" name="unit_cost" class="w-full border p-2 rounded" placeholder="Ej: 350.50" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block font-bold text-gray-700">Fecha de Llegada:</label>
                <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded">
                📥 Guardar y Aumentar Stock
            </button>
        </form>
    </div>
</body>
</html>