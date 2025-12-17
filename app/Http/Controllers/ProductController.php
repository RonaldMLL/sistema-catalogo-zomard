<?php

namespace App\Http\Controllers;

use App\Models\Product; // Importante: Importar el modelo
use Illuminate\Http\Request;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf; // <--- AGREGA ESTO
class ProductController extends Controller
{
    // 1. Mostrar el formulario
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // 2. Guardar el producto y la foto
    public function store(Request $request)
    {
        // Validamos que todo venga bien
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Solo imágenes, máx 2MB
            'category_id' => 'required|exists:categories,id', // Validar que la categoría exista
        ]);

        // A. MAGIA: Guardar la imagen en el disco duro
        // Esto la guarda en 'storage/app/public/products' y nos devuelve la ruta
        $imagePath = $request->file('image')->store('products', 'public');

        // B. Guardar la información en la Base de Datos
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_path' => $imagePath, // Guardamos la RUTA, no la imagen en sí
            'category_id' => $request->category_id, // <--- Guardamos la categoría
        ]);

        return redirect()->route('products.index')->with('success', '¡Producto creado con éxito!');
    }
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Filtro por Texto (Nombre)
        if ($request->filled('buscar')) {
            $query->where('name', 'like', '%' . $request->buscar . '%');
        }

        // 2. Filtro por Categoría (NUEVO)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(9)->withQueryString();        
        // 3. Traemos todas las categorías para llenar el <select>
        $categories = Category::all(); 

        return view('products.index', compact('products', 'categories'));
    }
    public function edit(Product $product)
    {
        $categories = Category::all(); // Necesitamos las categorías para el select
        return view('products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // OJO: es 'nullable' (opcional)
        ]);

        // DATOS BÁSICOS
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ];

        // LOGICA DE IMAGEN: Solo si subió una nueva, la cambiamos
        if ($request->hasFile('image')) {
            // 1. Guardar nueva imagen
            $imagePath = $request->file('image')->store('products', 'public');
            // 2. Agregar a los datos a actualizar
            $data['image_path'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', '¡Producto actualizado!');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente');
    }
    // Generar PDF
    public function downloadPdf()
    {
        $products = Product::all(); // Obtenemos los datos

        // 1. Cargamos una vista especial (que crearemos ahora)
        // y le pasamos los productos.
        $pdf = Pdf::loadView('products.pdf', compact('products'));

        // 2. Descargamos el archivo con un nombre automático
        return $pdf->download('catalogo-zomard.pdf');
    }
}