<div wire:poll.2s>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @foreach ($comentarios as $comentario)
    <x-filament::section>
        <x-slot name="heading">
            {{$comentario->creadorComentario->name}} - 
            {{ date('d/m/Y h:m:s', strtotime($comentario->created_at)) }} Hs.
        </x-slot>

        {{-- Content --}}

        {{$comentario->expediente_comentario}}
    </x-filament::section>
    <br>
    @endforeach
    <x-filament::pagination :paginator="$comentarios" />
</div>