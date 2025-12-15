<!DOCTYPE html>
<html>
<head>
    <title>Catálogo Zomard</title>
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; color: #166534; } /* Verde Zomard */
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            color: #333;
        }

        .price {
            color: #166534;
            font-weight: bold;
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <h1>Catálogo de Productos - Zomard</h1>
    <p style="text-align: center; color: #666;">Fecha: {{ date('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    @if($product->image_path)
                        <img src="{{ public_path('storage/' . $product->image_path) }}" class="product-img">
                    @else
                        <span>Sin foto</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $product->name }}</strong><br>
                    <small>{{ $product->description }}</small>
                </td>
                <td>
                    {{ $product->category ? $product->category->name : 'General' }}
                </td>
                <td>{{ $product->stock }}</td>
                <td class="price">Bs {{ number_format($product->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>