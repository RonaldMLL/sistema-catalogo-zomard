<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Producto</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nombre</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Categoría</label>
                <select name="category_id" class="w-full border p-2 rounded bg-white" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 font-bold mb-2">Precio</label>
                    <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 font-bold mb-2">Stock</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Descripción</label>
                <textarea name="description" class="w-full border p-2 rounded" rows="3">{{ $product->description }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Imagen (Opcional)</label>
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" class="w-20 h-20 object-cover mb-2 rounded">
                @endif
                <input type="file" name="image" class="w-full border p-2 rounded bg-gray-50" accept="image/*">
                <p class="text-xs text-gray-500 mt-1">Deja esto vacío si no quieres cambiar la foto.</p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('products.index') }}" class="text-gray-600 font-bold py-2 px-4">Cancelar</a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</body>
</html>