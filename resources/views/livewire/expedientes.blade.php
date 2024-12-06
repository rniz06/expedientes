<div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center" style="background-color: #FEDD00">
    <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <!-- Sección del logo -->
        <div class="hidden lg:flex w-full lg:w-1/2 items-center justify-center">
            <div class="w-2/3 h-2/3 bg-contain bg-center bg-no-repeat"
                style="background-image: url('https://expedientes.test/img/cbvp-logo-png.webp');">
            </div>
        </div>
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="mt-2 flex flex-col items-center">
                <div class="w-full flex-1 mt-2">

                    <div class="mb-4 border-b text-center">
                        <div
                            class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                            Ingrese los datos de su expediente
                        </div>
                    </div>

                    <form wire:submit.prevent="consultar" class="mx-auto max-w-xs">
                        <input wire:model="documento" name="documento"
                            class="w-full px-8 py-3 mb-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                            type="text" placeholder="Nro. Documento" required />
                        @error('documento')
                            <p>{{ $error }}</p>
                        @enderror

                        <select wire:model="prefijo" name="prefijo"
                            class="w-full px-8 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white">
                            <option value="">Seleccionar...</option>
                            @foreach ($prefijoAnhoExp as $prefijo)
                                <option value="{{ $prefijo }}">{{ $prefijo }}</option>
                            @endforeach
                        </select>
                        <input wire:model="expediente" name="expediente"
                            class="w-full px-8 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                            type="text" placeholder="Nro. Expediente" required />
                        @error('expediente')
                            <p>{{ $error }}</p>
                        @enderror
                        <button type="submit"
                            class="mt-5 tracking-wide font-semibold bg-yellow-300 text-white-500 w-full py-4 rounded-lg hover:bg-yellow-400 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                            <img src="https://www.svgrepo.com/show/7109/search.svg" class="w-6 h-6 -ml-2"
                                alt="">
                            <span class="ml-">
                                Consultar
                            </span>
                        </button>
                        <p class="mt-6 text-xs text-gray-600 text-center">
                            En caso de inconvenientes remitir correo a
                            <a href="#" class="border-b border-gray-500 border-dotted">
                                correo@correo.com
                            </a>
                            {{-- and its --}}
                            {{-- <a href="#" class="border-b border-gray-500 border-dotted">
                                Privacy Policy
                            </a> --}}
                        </p>
                    </form>
                    @if (session()->has('message'))
                        <div class="flex items-center p-4 mb-4 mt-2 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">{{ session('message') }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mt-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            @if ($resultado)
                <div class="mt-2 flex flex-col items-center">
                    <div class="w-full flex-1 mt-2">
                        <div class="mb-4 border-b text-center">
                            <div
                                class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                                Datos del expediente...
                            </div>
                        </div>

                        <div class="mx-auto max-w-xs">
                            <label for="Estado:">Estado:</label>
                            <input value="{{ $resultado->estado ?? 'N/A' }}"
                                class="w-full px-8 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-2"
                                type="text" placeholder="Estado" @disabled(true) />

                            <label for="Ubicación:">Ubicación:</label>
                            <input value="{{ $resultado->departamento ?? 'N/A' }}"
                                class="w-full px-8 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-2"
                                type="text" placeholder="Ubicacion" @disabled(true) />

                            <label for="Responsable:">Responsable:</label>
                            <input value="{{ $resultado->nombre_completo ?? 'N/A' }}"
                                class="w-full px-8 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-2"
                                type="text" placeholder="Responsable" @disabled(true) />
                            </p>
                        </div>

                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
