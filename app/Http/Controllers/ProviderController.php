<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    // Ver lista de proveedores
    public function index()
    {
        $providers = Provider::paginate(10);
        return view('providers.index', compact('providers'));
    }

    // Formulario de nuevo proveedor
    public function create()
    {
        return view('providers.create');
    }

    // Guardar en BD
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
        ]);

        Provider::create($request->all());

        return redirect()->route('providers.index')->with('success', 'Proveedor registrado correctamente.');
    }

    // (Opcional por ahora: Edit y Update los haremos si los necesitas)
}