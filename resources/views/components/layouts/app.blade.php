<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $title ?? 'Expedientes' }}</title>
</head>

<body class="flex flex-col min-h-screen">
    {{-- Header --}}
    <header class="bg-white py-4 shadow-md">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('img/cbvp-logo-png.webp') }}" alt="CBVP Logo" class="h-8 mr-4">
                <a href="{{ url('/') }}" class="text-gray-800 font-bold text-xl">CBVP | Expedientes</a>
            </div>
            <nav>
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ url('/app') }}"
                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">
                            Ingresar
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    {{-- Contenido principal --}}
    <main class="flex-grow bg-yellow-400 flex flex-col items-center justify-center p-4">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Departamento de TI | CBVP</p>
        </div>
    </footer>
</body>


</html>
