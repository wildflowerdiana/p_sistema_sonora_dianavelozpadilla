@extends('layouts.app')

@section('titulo', 'Buscar · Sonora')

@section('contenido')
    <div class="mb-6 max-w-md">
        <x-search_field placeholder="Canciones, artistas o playlists" />
    </div>

    <div class="mb-8 flex gap-2" data-chips role="group" aria-label="Filtrar resultados">
        <x-chip :activo="true">Todo</x-chip>
        <x-chip>Canciones</x-chip>
        <x-chip>Playlists</x-chip>
    </div>

    <h2 class="mb-4 text-xl font-bold">Canciones</h2>
    <div id="lista-busqueda" class="mb-8 rounded-lg bg-surface-raised p-4">
        @foreach ($pistas as $i => $pista)
            <x-song_row :indice="$i" :pista="$pista" />
        @endforeach
    </div>

    <h2 class="mb-4 text-xl font-bold">Explorar playlists</h2>
    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($playlists as $lista)
            <a href="{{ route('playlist') }}"
                class="rounded-md focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                <x-card :titulo="$lista['titulo']" :artista="$lista['artista']" :duracion="$lista['duracion']" />
            </a>
        @endforeach
    </div>
@endsection
