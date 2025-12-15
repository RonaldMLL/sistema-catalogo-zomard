<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Zomard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow mb-8">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-green-600">Zomard</div>
            
            <div class="flex gap-2">
                <a href="{{ route('products.pdf') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold flex items-center gap-2">
                    📄 PDF
                </a>

                <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Nuevo
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Nuestros Productos</h1>
            
            <form action="{{ route('products.index') }}" method="GET" class="flex gap-2 flex-wrap sm:flex-nowrap">
                
                <select name="category_id" class="border border-gray-300 rounded px-3 py-2 bg-white focus:outline-none focus:border-green-500">
                    <option value="">Todas las Categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="buscar" placeholder="Nombre del producto..." 
                       value="{{ request('buscar') }}"
                       class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">
                
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    🔍
                </button>
                
                @if(request('buscar') || request('category_id'))
                    <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 text-sm flex items-center">
                        X
                    </a>
                @endif
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                
                <div class="h-64 overflow-hidden bg-gray-200 flex items-center justify-center">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400">Sin imagen</span>
                    @endif
                </div>

                <div class="p-4">
                    <div class="mb-2">
                        @if($product->category)
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-1 rounded">
                                Sin Categoría
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $product->description }}
                    </p>
                    
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-2xl font-bold text-green-600">
                            Bs {{ number_format($product->price, 2) }}
                        </span>
                        <span class="text-xs font-bold text-gray-500 bg-gray-200 px-2 py-1 rounded">
                            Stock: {{ $product->stock }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center gap-2">
                
                    <a href="{{ route('products.edit', $product->id) }}" 
                    class="flex-1 text-center bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-3 rounded transition duration-300">
                        ✏️ Editar
                    </a>
                    
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                        onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');"
                        class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded transition duration-300">
                            🗑️ Borrar
                        </button>
                    </form>

                </div>
            </div>
            
            @endforeach
            
        </div>
    </div>

</body>
</html>