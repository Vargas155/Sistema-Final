@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-2">
    <h3 class="text-center text-info mb-3 fw-bold">🎮 ACTIVIDADES E INTERACCIONES DINÁMICAS DE FÍSICA</h3>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Navegación entre Actividades -->
            <div class="d-flex justify-content-center mb-3">
                <button class="btn btn-outline-info active fw-bold me-3 px-4 py-2 shadow" id="btnJuegoVectores" onclick="seleccionarJuego('vectores')">
                    🏹 Juego 1: Tiro al Blanco (Vectores)
                </button>
                <button class="btn btn-outline-warning fw-bold px-4 py-2 shadow" id="btnJuegoUnidades" onclick="seleccionarJuego('unidades')">
                    ⛽ Juego 2: Estación de Servicio (10 Vehículos Realistas)
                </button>
            </div>

            <!-- JUEGO 1: TIRO AL BLANCO CON VECTORES -->
            <div id="pantallaVectores" class="card card-custom p-3 shadow-lg bg-dark border border-info rounded-3">
                <div class="row align-items-center">
                    <div class="col-lg-8 text-center position-relative mb-3 mb-lg-0">
                        <canvas id="canvasVectores" width="720" height="420" style="background: #0284c7; border-radius: 12px; border: 3px solid #0284c7;"></canvas>
                        <div style="position: absolute; top: 15px; left: 30px; background: rgba(0, 0, 0, 0.75); padding: 8px 16px; border-radius: 8px; border: 1px solid #38bdf8;" class="text-start shadow">
                            <small class="text-info d-block fw-bold">🎯 TABLERO DE PUNTOS</small>
                            <span class="text-light d-block small">Puntaje: <b id="scoreText" class="text-warning fs-5">0</b> pts</span>
                        </div>
                    </div>

                    <div class="col-lg-4 text-start bg-black p-3 rounded-3 border border-secondary shadow-lg">
                        <h6 class="text-info fw-bold border-bottom border-secondary pb-2">🎯 VECTOR DE DISPARO</h6>
                        <div class="p-2 mb-3 bg-dark rounded border border-primary">
                            <label class="form-label text-info small m-0 fw-bold">Fuerza de Tensado (Magnitud V):</label>
                            <div class="d-flex align-items-center gap-2 my-1">
                                <input type="range" class="form-range" id="inputForce" min="10" max="40" step="1" value="25" oninput="actualizarVectorDisparo()">
                                <span id="labelForce" class="badge bg-primary fs-6" style="min-width: 65px;">25 N</span>
                            </div>
                        </div>

                        <div class="p-2 mb-3 bg-dark rounded border border-warning">
                            <label class="form-label text-warning small m-0 fw-bold">Ángulo de Inclinación (θ):</label>
                            <div class="d-flex align-items-center gap-2 my-1">
                                <input type="range" class="form-range" id="inputAngle" min="5" max="80" step="1" value="35" oninput="actualizarVectorDisparo()">
                                <span id="labelAngle" class="badge bg-warning text-dark fs-6" style="min-width: 55px;">35°</span>
                            </div>
                        </div>

                        <div class="p-2 bg-dark rounded border border-secondary mb-3 text-start small">
                            <span class="text-muted d-block">Componente Horizontal (Vx): <b id="valVx" class="text-info">20.48 m/s</b></span>
                            <span class="text-muted d-block">Componente Vertical (Vy): <b id="valVy" class="text-info">14.34 m/s</b></span>
                        </div>

                        <button class="btn btn-info fw-bold w-100 py-2 mb-2 text-dark fs-6 shadow" id="btnDisparar" onclick="dispararFlecha()">🏹 ¡SOLTAR FLECHA!</button>
                        <button class="btn btn-outline-light btn-sm w-100" onclick="reiniciarFlecha()">🔄 NUEVO INTENTO</button>
                    </div>
                </div>
            </div>

            <!-- JUEGO 2: CONVERSIÓN DE UNIDADES CON VEHÍCULOS Y AYUDA -->
            <div id="pantallaUnidades" class="card card-custom p-3 shadow-lg bg-dark border border-warning rounded-3 d-none">
                <div class="row align-items-center">
                    <!-- ÁREA DEL JUEGO CON AUTO Y TANQUE -->
                    <div class="col-lg-8 text-center mb-3 mb-lg-0">
                        <canvas id="canvasUnidades" width="720" height="420" style="background: #0f172a; border-radius: 12px; border: 2px solid #eab308;"></canvas>
                    </div>

                    <!-- PANEL DE TRABAJO Y GUÍA DE CONVERSIÓN -->
                    <div class="col-lg-4 text-start bg-black p-3 rounded-3 border border-secondary shadow-lg">
                        <h6 class="text-warning fw-bold border-bottom border-secondary pb-2">⛽ ESTACIÓN DE DESPACHO</h6>
                        
                        <!-- Tarjeta con Nombre del Vehículo e Indicación -->
                        <div class="alert alert-warning p-3 mb-2 border-start border-4 border-warning bg-black text-white">
                            <small class="fw-bold text-warning d-block" id="tipoVehiculoText">🚘 VEHÍCULO: SEDÁN FAMILIAR</small>
                            <h3 id="pedidoText" class="fw-bold text-white mb-0">12.0 Galones</h3>
                        </div>

                        <!-- TABLA REGISTRO DE FACTORES DE CONVERSIÓN -->
                        <div class="p-2 mb-3 bg-dark rounded border border-info small">
                            <span class="text-info fw-bold d-block mb-1">📘 TABLA DE FACTORES (MANUAL):</span>
                            <span class="text-light d-block">• 1 Galón (gal) = <b>3.785 Litros (L)</b></span>
                            <span class="text-muted d-block italic" id="calculoAproximadoGuia">💡 Multiplica: 12.0 × 3.785 ≈ 45.42 L</span>
                        </div>

                        <!-- CASILLA DE ENTRADA CON APROXIMACIÓN AUTOMÁTICA -->
                        <div class="mb-3">
                            <label class="form-label text-light fw-bold small">Ingresa tu resultado en Litros (S.I.):</label>
                            <input type="number" step="0.01" class="form-control bg-dark text-white fw-bold fs-4 text-success border-secondary" id="inputLitros" placeholder="Ej: 45.42" oninput="aproximarEntradaAuto(this)">
                            <small class="text-muted d-block mt-1">El valor se aproximará a 2 decimales automáticamente.</small>
                        </div>

                        <button class="btn btn-warning fw-bold w-100 py-2 mb-2 text-dark fs-6 shadow" onclick="ejecutarDespachoFuel()">
                            ⛽ BOMBEAR COMBUSTIBLE
                        </button>

                        <div id="feedbackUnidades" class="alert alert-secondary py-2 text-center small fw-bold">
                            Ingresa el resultado aproximado y despacha.
                        </div>

                        <button class="btn btn-outline-info btn-sm w-100 fw-bold py-2" onclick="generarNuevoCliente()">
                            🚗 SIGUIENTE VEHÍCULO (1 de 10)
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function seleccionarJuego(juego) {
        if (juego === 'vectores') {
            document.getElementById('pantallaVectores').classList.remove('d-none');
            document.getElementById('pantallaUnidades').classList.add('d-none');
            document.getElementById('btnJuegoVectores').classList.add('active');
            document.getElementById('btnJuegoUnidades').classList.remove('active');
            reiniciarFlecha();
        } else {
            document.getElementById('pantallaVectores').classList.add('d-none');
            document.getElementById('pantallaUnidades').classList.remove('d-none');
            document.getElementById('btnJuegoVectores').classList.remove('active');
            document.getElementById('btnJuegoUnidades').classList.add('active');
            generarNuevoCliente();
        }
    }

    /* ==========================================================================
       JUEGO 1: VECTORES (TIRO AL BLANCO)
       ========================================================================== */
    const cvsV = document.getElementById('canvasVectores');
    const ctxV = cvsV.getContext('2d');

    let puntaje = 0;
    let animIdV = null;

    let arquero = { x: 80, y: 320 };
    let flecha = { x: 80, y: 320, vx: 0, vy: 0, enVuelo: false };
    let diana = { x: 620, y: 220, radio: 40 };

    function actualizarVectorDisparo() {
        const F = parseFloat(document.getElementById('inputForce').value);
        const ang = parseFloat(document.getElementById('inputAngle').value);

        document.getElementById('labelForce').innerText = `${F} N`;
        document.getElementById('labelAngle').innerText = `${ang}°`;

        const rad = ang * Math.PI / 180;
        const vx = F * Math.cos(rad);
        const vy = F * Math.sin(rad);

        document.getElementById('valVx').innerText = `${vx.toFixed(2)} m/s`;
        document.getElementById('valVy').innerText = `${vy.toFixed(2)} m/s`;

        if (!flecha.enVuelo) renderizarTiroAlBlanco(vx, vy);
    }

    function renderizarTiroAlBlanco(vx = 0, vy = 0) {
        ctxV.clearRect(0, 0, cvsV.width, cvsV.height);

        ctxV.fillStyle = '#0284c7';
        ctxV.fillRect(0, 0, cvsV.width, 340);
        ctxV.fillStyle = '#15803d';
        ctxV.fillRect(0, 340, cvsV.width, 80);

        ctxV.fillStyle = '#ffffff';
        ctxV.beginPath();
        ctxV.arc(diana.x, diana.y, diana.radio, 0, Math.PI * 2);
        ctxV.fill();

        ctxV.fillStyle = '#dc2626';
        ctxV.beginPath();
        ctxV.arc(diana.x, diana.y, diana.radio * 0.65, 0, Math.PI * 2);
        ctxV.fill();

        ctxV.fillStyle = '#eab308';
        ctxV.beginPath();
        ctxV.arc(diana.x, diana.y, diana.radio * 0.3, 0, Math.PI * 2);
        ctxV.fill();

        ctxV.fillStyle = '#78350f';
        ctxV.fillRect(diana.x - 5, diana.y + diana.radio, 10, 340 - (diana.y + diana.radio));

        ctxV.fillStyle = '#0f172a';
        ctxV.fillRect(arquero.x - 15, arquero.y - 40, 20, 40);
        ctxV.fillStyle = '#fde047';
        ctxV.beginPath();
        ctxV.arc(arquero.x - 5, arquero.y - 50, 10, 0, Math.PI * 2);
        ctxV.fill();

        if (!flecha.enVuelo) {
            ctxV.strokeStyle = '#eab308';
            ctxV.lineWidth = 3;
            ctxV.setLineDash([5, 5]);
            ctxV.beginPath();
            ctxV.moveTo(arquero.x, arquero.y - 20);
            ctxV.lineTo(arquero.x + vx * 6, (arquero.y - 20) - vy * 6);
            ctxV.stroke();
            ctxV.setLineDash([]);
        }

        ctxV.save();
        ctxV.translate(flecha.x, flecha.y);

        if (flecha.enVuelo) {
            let anguloFlecha = Math.atan2(flecha.vy, flecha.vx);
            ctxV.rotate(anguloFlecha);
        } else {
            const ang = parseFloat(document.getElementById('inputAngle').value);
            ctxV.rotate(-ang * Math.PI / 180);
        }

        ctxV.strokeStyle = '#78350f';
        ctxV.lineWidth = 4;
        ctxV.beginPath();
        ctxV.moveTo(-25, 0);
        ctxV.lineTo(15, 0);
        ctxV.stroke();

        ctxV.fillStyle = '#dc2626';
        ctxV.beginPath();
        ctxV.moveTo(15, -4);
        ctxV.lineTo(25, 0);
        ctxV.lineTo(15, 4);
        ctxV.closePath();
        ctxV.fill();

        ctxV.restore();
    }

    function dispararFlecha() {
        if (flecha.enVuelo) return;

        const F = parseFloat(document.getElementById('inputForce').value);
        const ang = parseFloat(document.getElementById('inputAngle').value);
        const rad = ang * Math.PI / 180;

        flecha.vx = F * Math.cos(rad) * 0.45;
        flecha.vy = -F * Math.sin(rad) * 0.45;
        flecha.enVuelo = true;
        document.getElementById('btnDisparar').disabled = true;

        function bucleFisica() {
            flecha.x += flecha.vx;
            flecha.y += flecha.vy;
            flecha.vy += 0.25;

            renderizarTiroAlBlanco();

            const dist = Math.hypot(flecha.x - diana.x, flecha.y - diana.y);
            if (dist < diana.radio) {
                puntaje += 100;
                document.getElementById('scoreText').innerText = puntaje;
                setTimeout(() => {
                    alert('🎯 ¡EXCELENTE DISPARO! Impactaste la diana.');
                    moverDianaAleatoria();
                    reiniciarFlecha();
                }, 150);
                return;
            }

            if (flecha.y >= 340 || flecha.x >= cvsV.width || flecha.x < 0) {
                setTimeout(() => {
                    alert('❌ La flecha no tocó la diana. Intenta ajustar el ángulo o la fuerza.');
                    reiniciarFlecha();
                }, 150);
                return;
            }

            animIdV = requestAnimationFrame(bucleFisica);
        }

        bucleFisica();
    }

    function moverDianaAleatoria() {
        diana.y = Math.floor(Math.random() * 160) + 100;
    }

    function reiniciarFlecha() {
        if (animIdV) cancelAnimationFrame(animIdV);
        flecha = { x: arquero.x, y: arquero.y - 20, vx: 0, vy: 0, enVuelo: false };
        document.getElementById('btnDisparar').disabled = false;
        actualizarVectorDisparo();
    }

    /* ==========================================================================
       JUEGO 2: CONVERSIÓN DE UNIDADES (10 VEHÍCULOS REALISTAS)
       ========================================================================== */
    const cvsU = document.getElementById('canvasUnidades');
    const ctxU = cvsU.getContext('2d');

    // Catálogo de 10 Vehículos Realistas
    const catalogoVehiculos = [
        { id: 1, nombre: '🚘 SEDÁN FAMILIAR', color: '#2563eb', galones: 12, tipo: 'sedan' },
        { id: 2, nombre: '🛻 CAMIONETA PICKUP', color: '#dc2626', galones: 20, tipo: 'pickup' },
        { id: 3, nombre: '🏎️ DEPORTIVO GT', color: '#eab308', galones: 16, tipo: 'deportivo' },
        { id: 4, nombre: '🚙 SUV 4X4', color: '#059669', galones: 18, tipo: 'suv' },
        { id: 5, nombre: '🚚 CAMIÓN DE CARGA', color: '#d97706', galones: 35, tipo: 'camion' },
        { id: 6, nombre: '🚌 AUTOBÚS URBANO', color: '#9333ea', galones: 40, tipo: 'autobus' },
        { id: 7, nombre: '🚐 VAN EJECUTIVA', color: '#475569', galones: 22, tipo: 'van' },
        { id: 8, nombre: '🚕 TAXI COMPACTO', color: '#f59e0b', galones: 10, tipo: 'compacto' },
        { id: 9, nombre: '🚑 AMBULANCIA', color: '#ef4444', galones: 25, tipo: 'ambulancia' },
        { id: 10, nombre: '🚜 TRACTOR INDUSTRIAL', color: '#ca8a04', galones: 30, tipo: 'tractor' }
    ];

    let vehiculoActualIdx = 0;
    let nivelLiquido = 0;

    function generarNuevoCliente() {
        vehiculoActualIdx = (vehiculoActualIdx + 1) % catalogoVehiculos.length;
        const v = catalogoVehiculos[vehiculoActualIdx];

        document.getElementById('tipoVehiculoText').innerText = v.nombre;
        document.getElementById('pedidoText').innerText = `${v.galones}.0 Galones`;
        
        // Calculo de guía precalculado
        const litrosCalculados = (v.galones * 3.785).toFixed(2);
        document.getElementById('calculoAproximadoGuia').innerText = `💡 Multiplica: ${v.galones}.0 × 3.785 = ${litrosCalculados} L`;

        document.getElementById('inputLitros').value = '';
        document.getElementById('feedbackUnidades').className = "alert alert-secondary py-2 text-center small fw-bold";
        document.getElementById('feedbackUnidades').innerText = "Ingresa el valor aproximado y presiona bombear.";
        nivelLiquido = 0;
        renderizarGasolinera();
    }

    function aproximarEntradaAuto(elem) {
        // Mantiene la aproximación lista a 2 decimales
        if (elem.value && elem.value.includes('.')) {
            let partes = elem.value.split('.');
            if (partes[1].length > 2) {
                elem.value = parseFloat(elem.value).toFixed(2);
            }
        }
    }

    function renderizarGasolinera() {
        ctxU.clearRect(0, 0, cvsU.width, cvsU.height);
        const v = catalogoVehiculos[vehiculoActualIdx];

        // Dibujo del suelo de la estación
        ctxU.fillStyle = '#1e293b';
        ctxU.fillRect(0, 320, cvsU.width, 100);

        // DIBUJO REALISTA SEGÚN TIPO DE VEHÍCULO
        ctxU.save();
        ctxU.fillStyle = v.color;

        if (v.tipo === 'pickup' || v.tipo === 'camion') {
            // Cabina + Carga
            ctxU.beginPath();
            ctxU.roundRect(80, 210, 280, 110, [10, 15, 5, 5]);
            ctxU.fill();
            ctxU.fillStyle = '#0f172a';
            ctxU.fillRect(220, 170, 120, 150); // Caja de Carga
        } else if (v.tipo === 'autobus' || v.tipo === 'van') {
            // Chasis grande rectangular
            ctxU.beginPath();
            ctxU.roundRect(70, 160, 310, 160, [15, 15, 5, 5]);
            ctxU.fill();
            ctxU.fillStyle = '#38bdf8'; // Ventanas largas
            ctxU.fillRect(100, 180, 240, 45);
        } else {
            // Diseño sedán / deportivo ergonómico
            ctxU.beginPath();
            ctxU.roundRect(80, 220, 290, 100, [20, 40, 5, 5]);
            ctxU.fill();
            ctxU.fillStyle = '#38bdf8'; // Parabrisas
            ctxU.beginPath();
            ctxU.roundRect(220, 230, 95, 40, [10, 20, 0, 0]);
            ctxU.fill();
        }

        // Llantas con Rines detallados
        ctxU.fillStyle = '#020617';
        ctxU.beginPath();
        ctxU.arc(140, 320, 28, 0, Math.PI * 2);
        ctxU.arc(320, 320, 28, 0, Math.PI * 2);
        ctxU.fill();

        ctxU.fillStyle = '#cbd5e1'; // Rines metálicos
        ctxU.beginPath();
        ctxU.arc(140, 320, 12, 0, Math.PI * 2);
        ctxU.arc(320, 320, 12, 0, Math.PI * 2);
        ctxU.fill();

        ctxU.restore();

        // TANQUE DE DEPÓSITO DE COMBUSTIBLE CON MEDIDOR GRADUADO
        ctxU.strokeStyle = '#64748b';
        ctxU.lineWidth = 4;
        ctxU.strokeRect(480, 110, 130, 210);

        // Graduaciones métricas
        ctxU.fillStyle = '#94a3b8';
        for(let i = 120; i < 320; i += 20) {
            ctxU.fillRect(600, i, 10, 2);
        }

        // Líquido
        let gradFuel = ctxU.createLinearGradient(0, 320 - nivelLiquido, 0, 320);
        gradFuel.addColorStop(0, '#fef08a');
        gradFuel.addColorStop(1, '#eab308');
        ctxU.fillStyle = gradFuel;
        ctxU.fillRect(484, 316 - nivelLiquido, 122, nivelLiquido);

        ctxU.fillStyle = '#ffffff';
        ctxU.font = 'bold 14px Arial';
        ctxU.fillText(`Depósito del Vehículo`, 472, 90);
    }

    function ejecutarDespachoFuel() {
        const v = catalogoVehiculos[vehiculoActualIdx];
        const valUser = parseFloat(document.getElementById('inputLitros').value) || 0;
        const valCorrecto = parseFloat((v.galones * 3.785).toFixed(2));
        const diferencia = Math.abs(valUser - valCorrecto);

        const targetH = Math.min((valUser / valCorrecto) * 200, 200);
        let currH = 0;
 
        function animarBomba() {
            if (currH < targetH) {
                currH += 4;
                nivelLiquido = currH;
                renderizarGasolinera();
                requestAnimationFrame(animarBomba);
            } else {
                const fb = document.getElementById('feedbackUnidades');
                // Margen de tolerancia flexible para redondeo
                if (diferencia <= 0.8) {
                    fb.className = "alert alert-success py-2 text-center small fw-bold";
                    fb.innerText = `✅ ¡DESPACHO EXACTO! Llenaste ${valUser} Litros sin derramar nada.`;
                } else if (valUser < valCorrecto) {
                    fb.className = "alert alert-danger py-2 text-center small fw-bold";
                    fb.innerText = `⚠️ TANQUE INCOMPLETO: Faltaron ${(valCorrecto - valUser).toFixed(2)} Litros.`;
                } else {
                    fb.className = "alert alert-warning py-2 text-center small fw-bold";
                    fb.innerText = `🚨 DERRAME: Te pasaste por ${(valUser - valCorrecto).toFixed(2)} Litros.`;
                }
            }
        }

        animarBomba();
    }

    window.onload = function() {
        actualizarVectorDisparo();
    };
</script>
@endsection