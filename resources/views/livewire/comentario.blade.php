<div wire:poll.2s>
    @forelse ($comentarios as $comentario)
        <x-filament::section>
            <x-slot name="heading">
                {{ $comentario->creadorComentario->name }} - 
                {{ $comentario->created_at->format('d/m/Y H:i:s') }} Hs.
            </x-slot>

            {{-- Usar un método más legible para mostrar contenido --}}
            @if ($this->expandedIds->contains($comentario->id_expediente_comentario))
                {{ $comentario->expediente_comentario }}
            @else
                {{ Str::limit($comentario->expediente_comentario, 200) }}
            @endif

            {{-- Mejorar el botón de expansión --}}
            @if (Str::length($comentario->expediente_comentario) > 200)
                <button 
                    wire:click="toggleExpand({{ $comentario->id_expediente_comentario }})" 
                    class="text-blue-500 hover:text-blue-700 transition-colors"
                >
                    {{ $this->expandedIds->contains($comentario->id_expediente_comentario) 
                        ? 'Ver menos' 
                        : 'Ver más...' }}
                </button>
            @endif
        </x-filament::section>
        <br>
    @empty
        <p class="text-center text-gray-500">No hay comentarios</p>
    @endforelse

    <x-filament::pagination :paginator="$comentarios" />
</div>