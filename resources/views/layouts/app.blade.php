<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sonora')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/sonora-mark-light.svg') }}">

    <script>
        window.pistas = @json($pistas);
    </script>

    <script>
        try {
            document.documentElement.dataset.theme = localStorage.getItem('tema') ?? 'dark';
        } catch (_) {}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div
        class="grid h-screen grid-cols-1 md:grid-cols-[200px_1fr] {{ request()->routeIs('reproductor') ? 'grid-rows-[auto_minmax(0,1fr)] md:grid-rows-1' : 'grid-rows-[auto_minmax(0,1fr)_auto] md:grid-rows-[minmax(0,1fr)_80px]' }}">
        <nav class="flex items-center gap-1 overflow-x-auto bg-surface-raised px-2 py-2 md:flex-col md:items-stretch md:gap-2 md:overflow-visible md:px-4 md:py-6"
            aria-label="Principal">
            <div
                class="mr-2 flex shrink-0 items-center gap-2 text-xl font-extrabold tracking-tight text-accent md:mr-0 md:mb-6">
                <svg viewBox="0 0 64 64" class="size-7 shrink-0" fill="currentColor" aria-hidden="true">
                    <rect x="4" y="32" width="8" height="28" rx="4" />
                    <rect x="16" y="12" width="8" height="48" rx="4" />
                    <rect x="28" y="24" width="8" height="36" rx="4" />
                    <rect x="40" y="4" width="8" height="56" rx="4" />
                    <rect x="52" y="36" width="8" height="24" rx="4" />
                </svg>
                <span class="hidden text-ink sm:inline">Sonora</span>
            </div>
            <a href="{{ route('inicio') }}" @if (request()->routeIs('inicio')) aria-current="page" @endif
                class="flex shrink-0 items-center gap-3 rounded-md p-3 text-sm font-bold text-ink-muted hover:bg-surface-high hover:text-ink aria-[current=page]:bg-surface-high aria-[current=page]:text-ink focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                <x-icon name="home" /><span class="sr-only md:not-sr-only">Inicio</span>
            </a>
            <a href="{{ route('buscar') }}" @if (request()->routeIs('buscar')) aria-current="page" @endif
                class="flex shrink-0 items-center gap-3 rounded-md p-3 text-sm font-bold text-ink-muted hover:bg-surface-high hover:text-ink aria-[current=page]:bg-surface-high aria-[current=page]:text-ink focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                <x-icon name="search" /><span class="sr-only md:not-sr-only">Buscar</span>
            </a>
            <a href="{{ route('playlist') }}" @if (request()->routeIs('playlist')) aria-current="page" @endif
                class="flex shrink-0 items-center gap-3 rounded-md p-3 text-sm font-bold text-ink-muted hover:bg-surface-high hover:text-ink aria-[current=page]:bg-surface-high aria-[current=page]:text-ink focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                <x-icon name="library" /><span class="sr-only md:not-sr-only">Tu biblioteca</span>
            </a>
            <a href="{{ route('reproductor') }}" @if (request()->routeIs('reproductor')) aria-current="page" @endif
                class="flex shrink-0 items-center gap-3 rounded-md p-3 text-sm font-bold text-ink-muted hover:bg-surface-high hover:text-ink aria-[current=page]:bg-surface-high aria-[current=page]:text-ink focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                <x-icon name="play" /><span class="sr-only md:not-sr-only">Reproductor</span>

            </a>
            <x-button variant="ghost" id="tema" class="ml-auto shrink-0 px-3! md:mt-auto md:ml-0 md:px-6!">Cambiar
                tema</x-button>
        </nav>
        <main class="overflow-y-auto p-8 md:p-8">
            @yield('contenido')
        </main>
        @if (!request()->routeIs('reproductor'))
            <section
                class="grid grid-cols-1 items-center gap-2 border-t border-line bg-surface-raised px-4 py-2 md:col-span-2 md:grid-cols-[1fr_2fr_1fr] md:gap-0 md:py-0"
                aria-label="Reproductor">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex size-12 shrink-0 items-end gap-0.5 rounded-sm bg-surface-high p-2"
                        aria-hidden="true">
                        <i class="flex-1 rounded-pill bg-accent" style="height: 50%"></i>
                        <i class="flex-1 rounded-pill bg-accent" style="height: 90%"></i>
                        <i class="flex-1 rounded-pill bg-accent" style="height: 60%"></i>
                    </div>
                    <div class="min-w-0">
                        <p id="titulo" class="truncate text-sm font-bold"></p>
                        <p id="artista" class="truncate text-xs font-medium text-ink-muted"></p>
                    </div>
                    <button type="button" data-accion="favorito" aria-pressed="false"
                        aria-label="Guardar en tu biblioteca"
                        class="ml-auto shrink-0 rounded-pill p-2 text-ink-muted hover:text-ink aria-pressed:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                        <x-icon name="heart" />
                    </button>
                </div>

                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-center gap-4 md:gap-6">
                        <button type="button" data-accion="aleatorio" aria-pressed="false"
                            aria-label="Reproducción aleatoria"
                            class="rounded-pill p-2 text-ink-muted hover:text-ink aria-pressed:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                            <x-icon name="shuffle" />
                        </button>
                        <button type="button" data-accion="anterior" aria-label="Anterior"
                            class="rounded-pill hover:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                            <x-icon name="prev" />
                        </button>

                        <x-button data-accion="alternar" aria-label="Reproducir"
                            class="grid size-10 place-items-center p-0!">
                            <x-icon name="play" id="icono-play" />
                            <x-icon name="pause" id="icono-pausa" class="hidden" />
                        </x-button>

                        <button type="button" data-accion="siguiente" aria-label="Siguiente"
                            class="rounded-pill hover:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                            <x-icon name="next" />
                        </button>
                    </div>

                    <div class="flex w-full items-center gap-2 font-mono text-xs text-ink-muted">
                        <span id="tiempo">00:00</span>
                        <x-progress_bar class="flex-1" bar-id="barra" fill-id="relleno" :show-times="false" />
                        <span id="duracion">00:00</span>
                    </div>
                </div>

                <div class="hidden items-center justify-end gap-2 text-ink-muted md:flex">
                    <button type="button" data-accion="silenciar" aria-label="Silenciar"
                        class="rounded-pill hover:text-ink focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                        <x-icon name="volume" id="icono-volumen" />
                        <x-icon name="mute" id="icono-silencio" class="hidden" />
                    </button>
                    <x-progress_bar class="w-24" bar-id="volumen" label="Volumen" :percent="70"
                        :show-times="false" />
                </div>
            </section>
        @endif
    </div>
</body>

</html>
