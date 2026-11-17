const pistas = window.pistas ?? [];
let i = 0;         
let t = 0;          
let temporizador = null;
let aleatorio = false;

const historial = [];
function indiceSiguiente(){
    if (!aleatorio || pistas.length < 2) return i + 1;
    let n;
    do {n = Math.floor(Math.random() * pistas.length); } while (n === 1);
    historial.push(i);
    return n;
}

function indiceAnterior(){
    if (aleatorio && historial.length) return historial.pop();
    return i - 1;
}
const $ = (sel) => document.querySelector(sel);
const fmt = (s) => `${String(Math.floor(s / 60)).padStart(2, '0')}:${String(s % 60).padStart(2, '0')}`;

function pintar() {
    const p = pistas[i];
    if (!p) return;
    $('#titulo').textContent = p.titulo;
    $('#artista').textContent = p.artista;
    $('#tiempo').textContent = fmt(t);
    $('#duracion').textContent = fmt(p.dur);
    const pct = Math.round((t / p.dur) * 100);
    $('#relleno').style.width = `${pct}%`;
    $('#barra').setAttribute('aria-valuenow', pct);
    document.querySelectorAll('[data-pista]').forEach((fila) => {
        if(Number(fila.dataset.pista) === i) fila.setAttribute('aria-current', 'true');
        else fila.removeAttribute('aria-current');
    });
}

function reproduciendo() { return temporizador !== null; }

function pintarBoton() {
    const activo = reproduciendo();
    $('#icono-play').classList.toggle('hidden', activo);
    $('#icono-pausa').classList.toggle('hidden', !activo);
    $('[data-accion="alternar"]').setAttribute('aria-label', activo ? 'Pausar' : 'Reproducir');
}

function reproducir() {
    clearInterval(temporizador);
    temporizador = setInterval(() => {
        t++;
        if (t >= pistas[i].dur) { cambiar(indiceSiguiente()); return; }
        pintar();
    }, 1000);
    pintarBoton();
}

function pausar() {
    clearInterval(temporizador);
    temporizador = null;
    pintarBoton();
}

function cambiar(nueva) {
    i = (nueva + pistas.length) % pistas.length;
    t = 0;
    pintar();
}

document.addEventListener('click', (e) => {
    const accion = e.target.closest('[data-accion]')?.dataset.accion;
    if (accion === 'alternar') reproduciendo() ? pausar() : reproducir();
    if (accion === 'siguiente') cambiar(indiceSiguiente());
    if (accion === 'anterior') cambiar(indiceAnterior());
    const fila = e.target.closest('[data-pista]');
    if (fila) { cambiar(Number(fila.dataset.pista)); reproducir(); }
});

const raiz = document.documentElement;
try { raiz.dataset.theme = localStorage.getItem('tema') ?? 'dark'; } catch (_) {}
$('#tema')?.addEventListener('click', () => {
    raiz.dataset.theme = raiz.dataset.theme === 'dark' ? 'light' : 'dark';
    try { localStorage.setItem('tema', raiz.dataset.theme); } catch (_) {}
});

function formatear(s){
    return `${String(Math.floor(s / 60)).padStart(2, '0')}:${String(Math.floor(s % 60)).padStart(2, '0')}`;
}

function ajustarSlider(slider, porcentaje){
    const valor = Math.min(100, Math.max(0, porcentaje));

    slider.setAttribute('aria-valuenow', Math.round(valor));
    slider.querySelector('[data-fill]').style.width = `${valor}%`;

    const duracion = Number(slider.dataset.duration);
    const tiempo = slider.closest('[data-progress]')?.querySelector('[data-current]');
    if (duracion && tiempo) tiempo.textContent = formatear((valor / 100) * duracion);

    slider.dispatchEvent(new CustomEvent('slider:cambio', { detail: { porcentaje: valor}, bubbles:true}));
}

function porcentajeDesdePuntero(slider, evento){
    const caja = slider.getBoundingClientRect();
    return ((evento.clientX - caja.left) / caja.width) * 100;
}

let arrastrando = null;

document.addEventListener('pointerdown', (e) => {
    const slider = e.target.closest('[data-slider]');
    if (!slider) return;
    arrastrando = slider;
    slider.setPointerCapture(e.pointerId);
    slider.focus();
    ajustarSlider(slider, porcentajeDesdePuntero(slider, e))
})

document.addEventListener('pointermove', (e) => {
    if (arrastrando) ajustarSlider(arrastrando, porcentajeDesdePuntero(arrastrando, e));
})

document.addEventListener('pointerup', () => {
    arrastrando = null;
})

document.addEventListener('keydown', (e) => {
    const slider = e.target.closest('[data-slider]');
    if (!slider) return;
    
    const  actual = Number(slider.getAttribute('aria-valuenow'));
    let nuevo = null;

    if (e.key === 'ArrowRight' || e.key === 'ArrowUp') nuevo = actual + 5;
    if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') nuevo = actual - 5;
    if (e.key === 'Home') nuevo = 0;
    if (e.key === 'End') nuevo = 100;

    if (nuevo !== null){
        e.preventDefault();
        ajustarSlider(slider, nuevo);
    }
})

$('#barra')?.addEventListener('slider:cambio', (e) => {
    const p = pistas[i];
    if (!p) return;
    t = Math.min(p.dur - 1, Math.round((e.detail.porcentaje / 100) * p.dur));
    pintar();
});

let volumen = 70;
let volumenAnterior = 70;

function pintarVolumen(){
    const mudo = volumen === 0;
    $('#icono-volumen')?.classList.toggle('hidden', mudo);
    $('#icono-silencio')?.classList.toggle('hidden', !mudo);
    $('[data-accion="silenciar"]')?.setAttribute('aria-label', mudo ? 'Activar sonido' : 'Silenciar');
    $('#volumen')?.setAttribute('aria-valuetext', `${volumen} por ciento`);
}

$('#volumen')?.addEventListener('slider:cambio', (e) =>{
    volumen = Math.round(e.detail.porcentaje);
    if(volumen > 0) volumenAnterior = volumen;
    pintarVolumen();
})

document.addEventListener('click', (e) => {
    const toggleBtn = e.target.closest('[data-accion="aleatorio"], [data-accion="favorito"]');
    if (!toggleBtn) return;
    const activo = toggleBtn.getAttribute('aria-pressed') === 'true';
    toggleBtn.setAttribute('aria-pressed', activo ? 'false' : 'true');

    if (toggleBtn.dataset.accion === 'aleatorio'){
        aleatorio = !activo;
        historial.length = 0;
    }
})

document.addEventListener('click', (e) => {
    if (!e.target.closest('[data-accion="silenciar"]')) return;
    ajustarSlider($('#volumen'), volumen === 0 ? volumenAnterior : 0);
})

document.addEventListener('click', (e) => {
    const chip = e.target.closest('[data-chips] button');
    if (!chip) return;

    chip.closest('[data-chips]').querySelectorAll('button').forEach((c) => {
        c.setAttribute('aria-pressed', c === chip ? 'true' : 'false');
    })
})

$('#buscador')?.addEventListener('input', (e) => {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('#lista-busqueda [data-pista]').forEach((fila) => {
        fila.classList.toggle('hidden', !fila.textContent.toLowerCase().includes(q));
    });
});

const CLAVE_ESTADO = 'sonora-estado';

function guardarEstado() {
    try {
        sessionStorage.setItem(CLAVE_ESTADO, JSON.stringify({
            i, t, aleatorio, volumen, volumenAnterior,
            sonando: reproduciendo(),
        }));
    } catch (_) {}
}

function cargarEstado(){
    let g= null;
    try { g = JSON.parse(sessionStorage.getItem(CLAVE_ESTADO)); } catch (_) {}
    if (!g) return;

    if (Number.isInteger(g.i) && g.i >= 0 && g.i < pistas.length) {
        i = g.i;
        t = Math.min(Math.max(0, Number(g.t) || 0), pistas[i].dur - 1);
    }

    aleatorio = g.aleatorio === true;
    document.querySelectorAll('[data-accion="aleatorio"]').forEach((b) => {
        b.setAttribute('aria-pressed', aleatorio ? 'true' : 'false');
    });

    volumen = Number.isFinite(g.volumen) ? g.volumen : 70;
    const barraVol = $('#volumen');
    if (barraVol) ajustarSlider(barraVol, volumen);
    volumenAnterior = g.volumenAnterior > 0 ? g.volumenAnterior : 70;

    if (g.sonando) reproducir();
}
window.addEventListener('pagehide', guardarEstado);

cargarEstado();
pintar();
pintarVolumen();