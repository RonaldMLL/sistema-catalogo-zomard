<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nuevo Cliente</h1>

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nombre Completo</label>
                <input type="text" name="name" class="w-full border p-2 rounded" placeholder="Ej: Juan Perez" required>
            </div>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 font-bold mb-2">CI o NIT</label>
                    <input type="text" name="ci_nit" class="w-full border p-2 rounded" placeholder="Opcional">
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 font-bold mb-2">Celular *</label>
                    <input type="text" name="phone" class="w-full border p-2 rounded" placeholder="777..." required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Dirección / Zona</label>
                <input type="text" name="address" class="w-full border p-2 rounded" placeholder="Ej: Zona Satélite, Calle 5 #123">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Tipo de Cliente</label>
                <select name="type" class="w-full border p-2 rounded bg-white">
                    <option value="minorista">Minorista (Precio Normal)</option>
                    <option value="mayorista">Mayorista (Precio Especial)</option>
                    <option value="vip">VIP</option>
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('clients.index') }}" class="text-gray-500 font-bold py-2 px-4">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</body>
</html>