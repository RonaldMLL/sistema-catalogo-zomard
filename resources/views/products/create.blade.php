<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Registrar Inodoro / Producto</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nombre del Producto</label>
                <input type="text" name="name" class="w-full border p-2 rounded" placeholder="Ej: Inodoro One Piece Negro" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Categoría</label>
                <select name="category_id" class="w-full border p-2 rounded bg-white" required>
                    <option value="">Selecciona una opción...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 font-bold mb-2">Precio (Bs)</label>
                    <input type="number" step="0.01" name="price" class="w-full border p-2 rounded" placeholder="0.00" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 font-bold mb-2">Stock</label>
                    <input type="number" name="stock" class="w-full border p-2 rounded" placeholder="0" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Descripción</label>
                <textarea name="description" class="w-full border p-2 rounded" rows="3"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Imagen del Producto</label>
                <input type="file" name="image" class="w-full border p-2 rounded bg-gray-50" accept="image/*" required>
                <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. Máx 2MB.</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Guardar Producto
            </button>
        </form>
    </div>

</body>
</html>