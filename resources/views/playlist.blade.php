@extends('layouts.app')

@section('titulo', $playlistActual['titulo'] . ' · Sonora')

@section('contenido')
    <header class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-end">
        <div class="flex size-44 shrink-0 items-end gap-2 rounded-md bg-surface-high p-6">
            <i class="flex-1 rounded-pill bg-accent" style="height: 55%"></i>
            <i class="flex-1 rounded-pill bg-accent" style="height: 85%"></i>
            <i class="flex-1 rounded-pill bg-accent" style="height: 45%"></i>
            <i class="flex-1 rounded-pill bg-accent" style="height: 95%"></i>
            <i class="flex-1 rounded-pill bg-accent" style="height: 65%"></i>
        </div>

        <div class="flex flex-col gap-2">
            <span class="text-xs font-bold uppercase tracking-wider text-ink-muted">Playlist</span>
            <h1 class="text-[32px] leading-9 font-extrabold tracking-tight">{{ $playlistActual['titulo'] }}</h1>
            <p class="text-sm font-medium text-ink-muted">
                {{ $playlistActual['artista'] }} · <span class="font-mono text-xs">{{ count($pistas) }} canciones ·
                    {{ $playlistActual['duracion'] }}</span>
            </p>
            <div class="mt-2 flex items-center gap-3">
                <x-button variant="secondary" data-pista="0">Reproducir</x-button>
                <x-button variant="secondary">Seguir</x-button>
            </div>
        </div>
    </header>

    <section aria-label="Canciones de la playlist" class="rounded-lg bg-surface-raised p-4">
        @foreach ($pistas as $i => $pista)
            <x-song_row :indice="$i" :pista="$pista" :actual="$i === 0" />
        @endforeach
    </section>
@endsection
