<div class="min-h-screen flex flex-col justify-center items-center gap-4 p-4 bg-gray-100">
    <div
        class="flex flex-col lg:flex-row justify-center items-center border w-full max-w-5xl bg-white rounded-lg shadow-lg">
        <!-- Logo -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <img src="{{ asset('img/cbvp-logo-png.webp') }}" alt="Logo" class="w-3/4 lg:w-full">
        </div>
        <!-- Form -->
        <div class="w-full lg:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-6 text-center lg:text-left">Ingrese los datos de su
                expediente</h2>
            <form wire:submit.prevent="consultar" class="space-y-4">
                <!-- Número de Documento -->
                <div>
                    <label for="documento" class="block text-sm font-medium text-gray-600">Nro. Documento</label>
                    <input type="text" wire:model="documento"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        placeholder="Ingrese su número de documento" required>
                </div>
                <!-- Prefijo -->
                <div>
                    <label for="selector" class="block text-sm font-medium text-gray-600">Expediente</label>
                    <select wire:model="prefijo" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="">Seleccione una opción</option>
                        @foreach ($prefijoAnhoExp as $prefijo)
                            <option value="{{ $prefijo }}">{{ $prefijo }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Número de Expediente -->
                <div>
                    <label for="expediente" class="block text-sm font-medium text-gray-600">Nro. Expediente</label>
                    <input type="text" id="expediente" wire:model="expediente"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        placeholder="Ingrese el número de expediente" required>
                </div>
                <!-- Botón -->
                <div>
                    <button type="submit"
                        class="w-full bg-yellow-400 hover:bg-yellow-500 text-lg text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                        Consultar
                    </button>
                    {{-- <button type="submit"
                        class="w-full bg-yellow-400 hover:bg-yellow-500 text-lg text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                        <img src="https://www.svgrepo.com/show/7109/search.svg" class="w-5 h-5" alt="SVG BUSCAR">
                        Consultar
                    </button> --}}
                </div>
            </form>
            <!-- Ayuda -->
            <p class="mt-4 text-center text-sm text-gray-600">
                En caso de inconvenientes remitir correo a
                <a href="mailto:correo@correo.com" class="text-yellow-600 font-bold">correo@correo.com</a>
            </p>
            <!-- Alerta -->
            @if (session()->has('message'))
                <div
                    class="flex items-center p-4 mb-4 mt-2 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <div>
                        <span class="font-medium">{{ session('message') }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($resultado)
        {{-- Resultados --}}
        <div class="flex flex-wrap justify-between w-full max-w-5xl space-y-4 md:space-y-0 md:flex-nowrap ">
            {{-- Estado --}}
            <div
                class="w-full md:w-1/3 md:mr-2 bg-white p-8 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow duration-300">
                <h4 class="text-lg font-semibold mb-2">Estado:</h4>
                <p class="inline-block bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">
                    {{ $resultado->estado ?? 'N/A' }}
                </p>
            </div>

            {{-- Ubicación --}}
            <div
                class="w-full md:w-1/3 md:mr-2 bg-white p-8 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow duration-300">
                <h4 class="text-lg font-semibold mb-2">Ubicación:</h4>
                <p class="text-gray-700">{{ $resultado->departamento ?? 'N/A' }}</p>
            </div>

            {{-- Responsable --}}
            <div
                class="w-full md:w-1/3 bg-white p-8 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow duration-300">
                <h4 class="text-lg font-semibold mb-2">Responsable:</h4>
                <p class="text-gray-700">{{ $resultado->nombre_completo ?? 'N/A' }}</p>
            </div>
        </div>
    @endif


</div>
