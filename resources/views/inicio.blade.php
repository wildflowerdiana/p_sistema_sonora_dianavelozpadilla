@extends('layouts.app')

@section('titulo', 'Inicio · Sonora')

@section('contenido')
    <div class="mb-6 flex gap-2" data-chips role="group" aria-label="Filtrar contenido">
        <x-chip :activo="true">Todo</x-chip>
        <x-chip>Música</x-chip>
        <x-chip>Podcasts</x-chip>
    </div>

    <h1 class="mb-4 text-[32px] leading-9 font-extrabold tracking-tight">Buenas tardes</h1>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($playlists as $lista)
            <x-card :titulo="$lista['titulo']" :artista="$lista['artista']" :duracion="$lista['duracion']" />
        @endforeach
    </div>

    <h2 class="mt-8 mb-4 text-xl font-bold">Recién escuchado</h2>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
        @foreach (array_slice($pistas, 0, 4) as $p)
            <x-card :titulo="$p['titulo']" :artista="$p['artista']" :duracion="sprintf('%02d:%02d', intdiv($p['dur'], 60), $p['dur'] % 60)" />
        @endforeach
    </div>
@endsection
