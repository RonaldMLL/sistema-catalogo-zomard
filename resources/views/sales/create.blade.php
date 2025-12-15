<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Venta - Zomard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-green-700">🛒 Nueva Venta</h1>
            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-green-600 font-bold">Volver al Catálogo</a>
        </div>

        <form action="{{ route('sales.store') }}" method="POST" id="ventaForm">
            @csrf
            
            <div class="mb-6 bg-green-50 p-4 rounded border border-green-200">
                <label class="block text-green-800 font-bold mb-2">Cliente:</label>
                <select name="client_id" class="w-full border p-2 rounded bg-white" required>
                    <option value="">-- Seleccione un Cliente --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->type }})</option>
                    @endforeach
                </select>
            </div>

            <hr class="my-6">

            <div class="flex flex-col md:flex-row gap-4 items-end mb-4">
                <div class="flex-1 w-full">
                    <label class="block text-gray-700 font-bold mb-2">Producto:</label>
                    <select id="product_select" class="w-full border p-2 rounded bg-white">
                        <option value="">-- Seleccione Producto --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}" 
                                    data-name="{{ $product->name }}"
                                    data-stock="{{ $product->stock }}">
                                {{ $product->name }} - Bs {{ $product->price }} (Stock: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-32">
                    <label class="block text-gray-700 font-bold mb-2">Cantidad:</label>
                    <input type="number" id="quantity" value="1" min="1" class="w-full border p-2 rounded">
                </div>

                <button type="button" onclick="agregarAlCarrito()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold">
                    + Agregar
                </button>
            </div>

            <div class="bg-gray-50 rounded p-4 mb-6">
                <h3 class="font-bold text-lg mb-2">Detalle de la Venta</h3>
                <table class="w-full text-left bg-white rounded shadow-sm overflow-hidden">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="p-3">Producto</th>
                            <th class="p-3">Precio</th>
                            <th class="p-3">Cant.</th>
                            <th class="p-3">Subtotal</th>
                            <th class="p-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cart_table_body">
                        </tbody>
                    <tfoot>
                        <tr class="font-bold text-xl bg-green-100">
                            <td colspan="3" class="p-3 text-right">TOTAL A PAGAR:</td>
                            <td colspan="2" class="p-3 text-green-800">Bs <span id="total_display">0.00</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div id="hidden_inputs"></div>

            <div class="text-right">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded shadow-lg transition transform hover:scale-105">
                    ✅ FINALIZAR VENTA
                </button>
            </div>
        </form>
    </div>

    <script>
        let cart = []; // Array para guardar los productos
        
        function agregarAlCarrito() {
            // 1. Obtener valores de los inputs
            const select = document.getElementById('product_select');
            const quantityInput = document.getElementById('quantity');
            const selectedOption = select.options[select.selectedIndex];

            // 2. Validaciones simples
            if(!select.value) {
                alert("Por favor selecciona un producto");
                return;
            }

            const productId = select.value;
            const productName = selectedOption.getAttribute('data-name');
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const stock = parseInt(selectedOption.getAttribute('data-stock'));
            const quantity = parseInt(quantityInput.value);

            // Validar stock
            if(quantity > stock) {
                alert(`¡Stock insuficiente! Solo quedan ${stock} unidades.`);
                return;
            }

            // 3. Agregar al array (o actualizar si ya existe)
            const existingItem = cart.find(item => item.id === productId);
            if(existingItem) {
                if(existingItem.quantity + quantity > stock) {
                    alert("No puedes agregar más de lo que hay en stock.");
                    return;
                }
                existingItem.quantity += quantity;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: price,
                    quantity: quantity
                });
            }

            // 4. Renderizar (dibujar) la tabla de nuevo
            renderTable();
            
            // 5. Resetear inputs
            select.value = "";
            quantityInput.value = 1;
        }

        function renderTable() {
            const tbody = document.getElementById('cart_table_body');
            const hiddenContainer = document.getElementById('hidden_inputs');
            const totalDisplay = document.getElementById('total_display');
            
            tbody.innerHTML = "";
            hiddenContainer.innerHTML = "";
            let total = 0;

            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                // A. Dibujar fila visual
                const row = `
                    <tr class="border-b">
                        <td class="p-3">${item.name}</td>
                        <td class="p-3">${item.price}</td>
                        <td class="p-3">${item.quantity}</td>
                        <td class="p-3 font-bold text-gray-700">Bs ${subtotal.toFixed(2)}</td>
                        <td class="p-3">
                            <button type="button" onclick="removeItem(${index})" class="text-red-500 hover:text-red-700 font-bold">X</button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;

                // B. Crear inputs ocultos para Laravel
                // Esto genera: <input name="products[0][product_id]" value="1"> ...
                const inputId = `<input type="hidden" name="products[${index}][product_id]" value="${item.id}">`;
                const inputQty = `<input type="hidden" name="products[${index}][quantity]" value="${item.quantity}">`;
                
                hiddenContainer.innerHTML += inputId + inputQty;
            });

            totalDisplay.innerText = total.toFixed(2);
        }

        function removeItem(index) {
            cart.splice(index, 1);
            renderTable();
        }
    </script>

</body>
</html>