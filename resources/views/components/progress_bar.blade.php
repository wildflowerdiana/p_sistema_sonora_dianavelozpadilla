@props([
    'percent' => 0,
    'label' => 'Progreso de la cancion',
    'current' => '00:00',
    'total' => '00:00',
    'duration' => 0,
    'showTimes' => true,
    'barId' => null,
    'fillId' => null,
    'currentId' => null,
    'totalId' => null,
])

<div data-progress {{ $attributes }}>
    <div data-slider @if ($barId) id="{{ $barId }}" @endif
        data-duration="{{ $duration }}" role="slider", tabindex="0", aria-label="{{ $label }}"
        aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $percent }}"
        class="cursor-pointer rounded-md py-2 focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
        <div class="h-1 rounded-pill bg-surface-high">
            <div data-fill @if ($fillId) id="{{ $fillId }}" @endif
                class="h-1 rounded-pill bg-accent" style="width: {{ $percent }}%"></div>
        </div>
    </div>

    @if ($showTimes)
        <div class="mt-1 flex justify-between font-mono text-xs text-ink-muted">
            <span data-current
                @if ($currentId) id="{{ $currentId }}" @endif>{{ $current }}</span>
            <span data-total
                @if ($totalId) id="{{ $totalId }}" @endif>{{ $total }}</span>
        </div>
    @endif

</div>
