<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores - Zomard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow p-4 mb-6">
        <div class="max-w-6xl mx-auto flex gap-4">
            <a href="{{ route('dashboard') }}" class="font-bold text-gray-500 hover:text-green-600">🏠 Inicio</a>
            <span class="text-gray-300">|</span>
            <span class="font-bold text-blue-600">🚢 Proveedores</span>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">🏭 Proveedores (Fábricas)</h1>
            <a href="{{ route('providers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">
                + Nuevo Proveedor
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Empresa</th>
                        <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Contacto</th>
                        <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">País</th>
                        <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Email/Tel</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $provider)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="font-bold text-gray-900">{{ $provider->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $provider->address }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $provider->contact_name ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $provider->country }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p>{{ $provider->email }}</p>
                            <p>{{ $provider->phone }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">
                {{ $providers->links() }}
            </div>
        </div>
    </div>
</body>
</html>