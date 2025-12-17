<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Proveedor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">🏭 Registrar Fábrica / Proveedor</h2>
        
        <form action="{{ route('providers.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nombre de la Empresa:</label>
                <input type="text" name="name" class="w-full border p-2 rounded" placeholder="Ej: Shanghai Sanitary Co." required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nombre de Contacto:</label>
                    <input type="text" name="contact_name" class="w-full border p-2 rounded" placeholder="Ej: Mr. Wang">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">País:</label>
                    <input type="text" name="country" value="China" class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" class="w-full border p-2 rounded">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Teléfono / WhatsApp:</label>
                <input type="text" name="phone" class="w-full border p-2 rounded">
            </div>

            <div class="text-right">
                <a href="{{ route('providers.index') }}" class="text-gray-500 mr-4">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>