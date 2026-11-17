@extends('layouts.app')

@section('titulo', 'Reproductor · Sonora')

@section('contenido')
    <div class="grid h-full grid-cols-1 gap-8 lg:grid-cols-[1fr_340px]">
        <section class="flex flex-col items-center justify-center rounded-lg bg-surface-base p-6 text-center"
            aria-label="Reproducción actual">
            <div class="mb-8 flex size-64 items-end gap-3 rounded-md bg-surface-high p-8 sm:size-72" aria-hidden="true">
                <i class="flex-1 rounded-pill bg-accent" style="height: 45%"></i>
                <i class="flex-1 rounded-pill bg-accent" style="height: 80%"></i>
                <i class="flex-1 rounded-pill bg-accent" style="height: 55%"></i>
                <i class="flex-1 rounded-pill bg-accent" style="height: 95%"></i>
                <i class="flex-1 rounded-pill bg-accent" style="height: 70%"></i>
            </div>
            <h1 id="titulo" class="text-[32px] leading-9 font-extrabold tracking-tight text-ink">
                {{ $pistas[0]['titulo'] ?? 'Sin pista' }}
            </h1>
            <p class="mt-2 text-sm font-medium text-ink-muted">
                <span id="artista">{{ $pistas[0]['artista'] ?? '' }}</span> · Sin prisa
            </p>
            <div class="mt-8 flex w-full max-w-md items-center gap-3 font-mono text-xs text-ink-muted">
                <span id="tiempo">00:00</span>
                <x-progress_bar class="flex-1" bar-id="barra" fill-id="relleno" :show-times="false" />
                <span id="duracion">00:00</span>
            </div>
            <div class="mt-6 flex items-center gap-6">
                <button type="button" data-accion="aleatorio" aria-pressed="false" aria-label="Reproducción aleatoria"
                    class="rounded-pill p-2 text-ink-muted hover:text-ink aria-pressed:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                    <x-icon name="shuffle" />
                </button>

                <button type="button" data-accion="anterior" aria-label="Anterior"
                    class="rounded-pill p-2 text-ink hover:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                    <x-icon name="prev" />
                </button>

                <x-button data-accion="alternar" aria-label="Reproducir" class="grid size-12 place-items-center p-0!">
                    <x-icon name="play" id="icono-play" />
                    <x-icon name="pause" id="icono-pausa" class="hidden" />
                </x-button>

                <button type="button" data-accion="siguiente" aria-label="Siguiente"
                    class="rounded-pill p-2 text-ink hover:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                    <x-icon name="next" />
                </button>

                <button type="button" data-accion="favorito" aria-pressed="false" aria-label="Guardar en tu biblioteca"
                    class="rounded-pill p-2 text-ink-muted hover:text-ink aria-pressed:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                    <x-icon name="heart" />
                </button>
            </div>
        </section>

        <aside class="overflow-y-auto rounded-lg bg-surface-raised p-4" aria-label="En cola">
            <h2 class="mb-4 px-2 text-xl font-bold text-ink">En cola</h2>
            <div class="flex flex-col gap-1">
                @foreach ($pistas as $i => $pista)
                    <x-song_row :indice="$i" :pista="$pista" :actual="$i === 0" />
                @endforeach
            </div>
        </aside>
    </div>
@endsection
