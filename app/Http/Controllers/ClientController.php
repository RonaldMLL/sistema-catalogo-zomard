<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // 1. Mostrar lista de clientes
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', compact('clients'));
    }

    // 2. Mostrar formulario de registro
    public function create()
    {
        return view('clients.create');
    }

    // 3. Guardar el cliente en BD
    public function store(Request $request)
    {
        // Validamos (el celular y nombre son obligatorios)
        $request->validate([
            'name' => 'required',
            'phone' => 'required', // Vital para cobrar
            'ci_nit' => 'nullable',
            'address' => 'nullable',
            'type' => 'required'
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', '¡Cliente registrado correctamente!');
    }
}