@extends('layouts.app')

@section('content')
<h3 class="text-center text-info mb-4">📐 SIMULADOR DE VECTORES Y FUERZA RESULTANTE</h3>

<div class="row">
    <!-- Panel de Entradas y Resultados -->
    <div class="col-md-5">
        <div class="card card-custom p-3 shadow-lg">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-info m-0">Panel de Vectores</h5>
                <div>
                    <button class="btn btn-sm btn-outline-success fw-bold" onclick="agregarVector()">+ Agregar Vector</button>
                </div>
            </div>

            <!-- Formulario de Vectores Dinámicos -->
            <form id="vectorForm">
                @csrf
                <div id="vectorsContainer" style="max-height: 250px; overflow-y: auto;" class="pe-2">
                    <!-- Los vectores se generan y actualizan dinámicamente -->
                </div>
            </form>

            <!-- Resultados Analíticos -->
            <div class="mt-3 p-3 bg-dark rounded border border-secondary">
                <h6 class="text-warning fw-bold border-bottom border-secondary pb-1">Resultados Analíticos:</h6>
                
                <div class="row text-center my-2">
                    <div class="col-6">
                        <small class="text-muted d-block">ΣFx (Componente X)</small>
                        <span id="resFx" class="fw-bold text-info fs-5">0.00 N</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">ΣFy (Componente Y)</small>
                        <span id="resFy" class="fw-bold text-info fs-5">0.00 N</span>
                    </div>
                </div>

                <div class="row text-center my-2 border-top border-secondary pt-2">
                    <div class="col-6">
                        <small class="text-muted d-block">Vector Resultante (R)</small>
                        <span id="resR" class="fw-bold text-danger fs-5">0.00 N</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Ángulo Resultante (θ)</small>
                        <span id="resAngle" class="fw-bold text-warning fs-5">0.00°</span>
                    </div>
                </div>

                <div class="text-center my-2">
                    <small class="text-muted d-block">Dirección y Sentido:</small>
                    <span id="resQuad" class="badge bg-primary text-wrap">I Cuadrante</span>
                </div>

                <button class="btn btn-outline-warning btn-sm w-100 mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#pasosProcedimiento">
                    Mostrar / Ocultar Cálculo Detallado (Paso a Paso)
                </button>

                <div class="collapse mt-2" id="pasosProcedimiento">
                    <div class="card card-body bg-black text-white p-2 small border border-warning" id="detallePasos" style="font-family: monospace;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plano Cartesiano Interactivo -->
    <div class="col-md-7 text-center">
        <div class="card card-custom p-2 shadow-lg">
            <small class="text-info mb-1 fw-bold">💡 Haz clic sostenido en la bolita de cualquier vector para moverlo libremente.</small>
            <canvas id="vectorCanvas" width="600" height="500" style="background-color: #080c14; border-radius: 8px; touch-action: none;"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const canvas = document.getElementById('vectorCanvas');
    const ctx = canvas.getContext('2d');
    const cx = canvas.width / 2;
    const cy = canvas.height / 2;
    const scale = 14;

    let dragVectorIndex = -1;
    const colors = ['#00b4d8', '#38b000', '#e9c46a', '#f72585', '#7209b7', '#4cc9f0'];

    let vectorList = [
        { mag: 10, ang: 30 },
        { mag: 8, ang: 120 },
        { mag: 6, ang: 240 }
    ];

    function renderInputs() {
        const container = document.getElementById('vectorsContainer');
        container.innerHTML = '';

        vectorList.forEach((v, i) => {
            const color = colors[i % colors.length];
            container.innerHTML += `
                <div class="row mb-2 align-items-center bg-dark p-1 rounded border-start border-3" style="border-color: ${color} !important;">
                    <div class="col-1 fw-bold p-0 text-center" style="color: ${color}">V${i+1}</div>
                    <div class="col-5 pe-1">
                        <label class="form-label text-light small m-0">Mag (N):</label>
                        <input type="number" class="form-control form-control-sm bg-black text-white" id="v_mag_${i}" value="${v.mag}" step="0.1" oninput="updateFromInput(${i})">
                    </div>
                    <div class="col-5 ps-1 pe-1">
                        <label class="form-label text-light small m-0">Áng (°):</label>
                        <input type="number" class="form-control form-control-sm bg-black text-white" id="v_ang_${i}" value="${v.ang}" step="1" oninput="updateFromInput(${i})">
                    </div>
                    <div class="col-1 p-0 text-center">
                        ${vectorList.length > 1 ? `<button type="button" class="btn btn-sm btn-link text-danger p-0 fw-bold" onclick="eliminarVector(${i})">✕</button>` : ''}
                    </div>
                </div>
            `;
        });
    }

    function agregarVector() {
        if (vectorList.length >= 6) return;
        vectorList.push({ mag: 5, ang: 45 });
        renderInputs();
        calcularYDibujar();
    }

    function eliminarVector(index) {
        if (vectorList.length <= 1) return;
        vectorList.splice(index, 1);
        renderInputs();
        calcularYDibujar();
    }

    function updateFromInput(index) {
        const magVal = parseFloat(document.getElementById(`v_mag_${index}`).value) || 0;
        const angVal = parseFloat(document.getElementById(`v_ang_${index}`).value) || 0;

        vectorList[index].mag = magVal;
        vectorList[index].ang = angVal;

        calcularYDibujar();
    }

    function calcularYDibujar() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Ejes Cartesianos
        ctx.strokeStyle = '#334155';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(0, cy); ctx.lineTo(canvas.width, cy);
        ctx.moveTo(cx, 0); ctx.lineTo(cx, canvas.height);
        ctx.stroke();

        // Cuadrícula y números
        ctx.fillStyle = '#64748b';
        ctx.font = '10px Arial';
        for (let i = -15; i <= 15; i += 5) {
            if (i !== 0) {
                ctx.fillText(i, cx + i * scale - 5, cy + 15);
                ctx.fillText(-i, cx - 15, cy + i * scale + 4);
            }
        }

        let sumFx = 0;
        let sumFy = 0;
        let htmlSteps = '<strong>MÉTODO DE COMPONENTES RECTANGULARES:</strong><br><br>';

        vectorList.forEach((v, i) => {
            const rad = v.ang * (Math.PI / 180);
            const fx = v.mag * Math.cos(rad);
            const fy = v.mag * Math.sin(rad);

            sumFx += fx;
            sumFy += fy;

            const ex = cx + fx * scale;
            const ey = cy - fy * scale;
            const color = colors[i % colors.length];

            // Línea del Vector
            ctx.strokeStyle = color;
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(cx, cy); ctx.lineTo(ex, ey);
            ctx.stroke();

            // Círculo interactivo (área visible y área de agarre)
            ctx.fillStyle = color;
            ctx.beginPath();
            ctx.arc(ex, ey, 8, 0, Math.PI * 2);
            ctx.fill();
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Texto descriptivo
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 12px Arial';
            ctx.fillText(`V${i+1} (${v.mag}N, ${v.ang}°)`, ex + 10, ey - 5);

            htmlSteps += `<b>V${i+1}:</b> Fx = ${v.mag}·cos(${v.ang}°) = <b>${fx.toFixed(2)} N</b> | Fy = ${v.mag}·sen(${v.ang}°) = <b>${fy.toFixed(2)} N</b><br>`;
        });

        // Resultante
        const R = Math.sqrt(sumFx * sumFx + sumFy * sumFy);
        let angR = Math.atan2(sumFy, sumFx) * (180 / Math.PI);
        if (angR < 0) angR += 360;

        let cuadrante = "";
        if (sumFx >= 0 && sumFy >= 0) cuadrante = "I Cuadrante (Norte del Este)";
        else if (sumFx < 0 && sumFy >= 0) cuadrante = "II Cuadrante (Norte del Oeste)";
        else if (sumFx < 0 && sumFy < 0) cuadrante = "III Cuadrante (Sur del Oeste)";
        else cuadrante = "IV Cuadrante (Sur del Este)";

        if (R > 0) {
            const radR = angR * (Math.PI / 180);
            const exR = cx + (R * Math.cos(radR)) * scale;
            const eyR = cy - (R * Math.sin(radR)) * scale;

            ctx.strokeStyle = '#e63946';
            ctx.lineWidth = 3;
            ctx.setLineDash([5, 5]);
            ctx.beginPath();
            ctx.moveTo(cx, cy); ctx.lineTo(exR, eyR);
            ctx.stroke();
            ctx.setLineDash([]);

            ctx.fillStyle = '#e63946';
            ctx.font = 'bold 12px Arial';
            ctx.fillText(`R (${R.toFixed(2)}N, ${angR.toFixed(1)}°)`, exR + 10, eyR);
        }

        document.getElementById('resFx').innerText = `${sumFx.toFixed(2)} N`;
        document.getElementById('resFy').innerText = `${sumFy.toFixed(2)} N`;
        document.getElementById('resR').innerText = `${R.toFixed(2)} N`;
        document.getElementById('resAngle').innerText = `${angR.toFixed(2)}°`;
        document.getElementById('resQuad').innerText = cuadrante;

        htmlSteps += `<hr class="my-1 border-secondary">`;
        htmlSteps += `<b>SUMATORIA:</b><br>`;
        htmlSteps += `ΣFx = <b>${sumFx.toFixed(2)} N</b><br>`;
        htmlSteps += `ΣFy = <b>${sumFy.toFixed(2)} N</b><br><br>`;
        htmlSteps += `<b>MAGNITUD RESULTANTE:</b><br>`;
        htmlSteps += `R = √((ΣFx)² + (ΣFy)²) = √((${sumFx.toFixed(2)})² + (${sumFy.toFixed(2)})²)<br>`;
        htmlSteps += `R = <b>${R.toFixed(2)} N</b><br><br>`;
        htmlSteps += `<b>DIRECCIÓN Y SENTIDO:</b><br>`;
        htmlSteps += `θ = tan⁻¹(|ΣFy / ΣFx|) = <b>${angR.toFixed(2)}°</b> (${cuadrante})`;

        document.getElementById('detallePasos').innerHTML = htmlSteps;
    }

    // Función para obtener coordenadas exactas ajustando la escala del canvas
    function getMousePos(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;

        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top) * scaleY
        };
    }

    // Eventos de Mouse con área de detección ampliada (25px)
    canvas.addEventListener('mousedown', (e) => {
        const pos = getMousePos(e);

        vectorList.forEach((v, i) => {
            const rad = v.ang * (Math.PI / 180);
            const ex = cx + (v.mag * Math.cos(rad)) * scale;
            const ey = cy - (v.mag * Math.sin(rad)) * scale;

            const dist = Math.hypot(pos.x - ex, pos.y - ey);
            if (dist < 25) { // Tolerancia amplia para poder agarrar la bolita fácilmente
                dragVectorIndex = i;
            }
        });
    });

    canvas.addEventListener('mousemove', (e) => {
        const pos = getMousePos(e);

        // Cambio de cursor cuando está sobre una bolita
        let hover = false;
        vectorList.forEach((v) => {
            const rad = v.ang * (Math.PI / 180);
            const ex = cx + (v.mag * Math.cos(rad)) * scale;
            const ey = cy - (v.mag * Math.sin(rad)) * scale;
            if (Math.hypot(pos.x - ex, pos.y - ey) < 25) hover = true;
        });
        canvas.style.cursor = hover || dragVectorIndex !== -1 ? 'grab' : 'crosshair';

        if (dragVectorIndex === -1) return;

        const dx = (pos.x - cx) / scale;
        const dy = -(pos.y - cy) / scale;

        let mag = Math.hypot(dx, dy);
        let ang = Math.atan2(dy, dx) * (180 / Math.PI);
        if (ang < 0) ang += 360;

        vectorList[dragVectorIndex].mag = parseFloat(mag.toFixed(1));
        vectorList[dragVectorIndex].ang = Math.round(ang);

        document.getElementById(`v_mag_${dragVectorIndex}`).value = mag.toFixed(1);
        document.getElementById(`v_ang_${dragVectorIndex}`).value = Math.round(ang);

        calcularYDibujar();
    });

    canvas.addEventListener('mouseup', () => {
        dragVectorIndex = -1;
        canvas.style.cursor = 'crosshair';
    });

    window.onload = () => {
        renderInputs();
        calcularYDibujar();
    };
</script>
@endsection