<?php

use Illuminate\Support\Facades\Route;

$pistas = [
    ['titulo' => 'Noches de lluvia', 'artista' => 'Mar Abierto', 'dur' => 258],
    ['titulo' => 'Hora azul', 'artista' => 'Luz de Norte', 'dur' => 232],
    ['titulo' => 'Camino de sal', 'artista' => 'Valle Tenue', 'dur' => 205],
    ['titulo' => 'Ciudad dormida', 'artista' => 'Eco de Barro', 'dur' => 241],
    ['titulo' => 'Cuarto de espejos', 'artista' => 'Faro Interior', 'dur' => 190],
    ['titulo' => 'Tierra mojada', 'artista' => 'Ana Lumbre', 'dur' => 276],
    ['titulo' => 'Última estación', 'artista' => 'Paso Lento', 'dur' => 223],
    ['titulo' => 'Brasa y ceniza', 'artista' => 'Casa del Viento', 'dur' => 248],
];
$playlists = [
    ['titulo' => 'Mezcla diaria 1', 'artista' => 'Para ti', 'duracion' => '1:12:40'],
    ['titulo' => 'Para concentrarte', 'artista' => 'Playlist', 'duracion' => '48:05'],
    ['titulo' => 'Camino a casa', 'artista' => 'Playlist', 'duracion' => '36:21'],
    ['titulo' => 'Noche tranquila', 'artista' => 'Playlist', 'duracion' => '1:03:12'],
    ['titulo' => 'Para escuchar con la familia', 'artista' => 'Playlist', 'duracion' => '2:10:30'],
    ['titulo' => 'Viejitas pero bonitas', 'artista' => 'Playlist', 'duracion' => '13:00:00'],
];


Route::get('/', fn() => view('inicio', [
    'pistas' => $pistas,
    'playlists' => $playlists,
]))->name('inicio');

Route::get('/playlist', fn() => view('playlist', [
    'pistas' => $pistas,
    'playlistActual' => $playlists[0],
]))->name('playlist');

Route::get('/buscar', fn() => view('buscar', [
    'pistas' => $pistas,
    'playlists' => $playlists,
]))->name('buscar');

Route::get('/reproductor', fn() => view('reproductor', [
    'pistas' => $pistas,
]))->name('reproductor');
