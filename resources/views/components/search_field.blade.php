@props(['id' => 'buscador', 'label' => 'Buscar', 'placeholder' => 'Canciones, artistas o playlist'])

<div>
    <label for="{{ $id }}" class="sr-only">{{ $label }}</label>
    <input type="search" id="{{ $id }}" placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full rounded-pill border-2 border-line-strong bg-surface-high px-4 py-3 text-sm text-ink placeholder:text-ink-muted focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus']) }}>
</div>
