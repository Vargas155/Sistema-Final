@extends('layouts.app')

@section('content')
<h3 class="text-center text-warning mb-4">🔄 CONVERSOR DE UNIDADES Y SIMULADOR VISUAL</h3>

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-custom p-4 shadow-lg">
            <div class="row">
                <!-- Panel de Entradas -->
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label text-info fw-bold">1. Selecciona la Magnitud:</label>
                        <select class="form-select bg-dark text-white fw-bold" id="magnitudeSelect" onchange="cambiarMagnitud()">
                            <option value="longitud">📏 Longitud</option>
                            <option value="area">📐 Área</option>
                            <option value="volumen">🧪 Volumen</option>
                            <option value="tiempo">⏱️ Tiempo</option>
                            <option value="angulo">🔄 Ángulo</option>
                            <option value="velocidad">🚗 Velocidad</option>
                            <option value="aceleracion">🏎️ Aceleración</option>
                            <option value="masa">🌾 Masa</option>
                            <option value="fuerza">🏋️ Fuerza</option>
                            <option value="presion">🎈 Presión</option>
                            <option value="energia">🔥 Energía</option>
                            <option value="potencia">⚡ Potencia</option>
                            <option value="temperatura">🌡️ Temperatura</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light fw-bold">2. Cantidad a Convertir:</label>
                        <input type="number" class="form-control bg-dark text-white fw-bold fs-5 text-warning" id="inputValue" value="54" oninput="ejecutarConversion()">
                    </div>

                    <!-- Sistema de Origen (De) -->
                    <div class="mb-2">
                        <label class="form-label text-light fw-bold small">3. Sistema de Origen (De):</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="sysFrom" id="sysFromSI" value="SI" checked onchange="filtrarUnidades()">
                            <label class="btn btn-outline-primary btn-sm fw-bold" for="sysFromSI">Sistema Internacional (S.I.)</label>

                            <input type="radio" class="btn-check" name="sysFrom" id="sysFromIng" value="ING" onchange="filtrarUnidades()">
                            <label class="btn btn-outline-danger btn-sm fw-bold" for="sysFromIng">Sistema Inglés</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <select class="form-select bg-dark text-white fw-bold" id="fromUnit" onchange="ejecutarConversion()"></select>
                    </div>

                    <!-- Sistema de Destino (A) -->
                    <div class="mb-2">
                        <label class="form-label text-light fw-bold small">4. Sistema de Destino (A):</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="sysTo" id="sysToSI" value="SI" onchange="filtrarUnidades()">
                            <label class="btn btn-outline-primary btn-sm fw-bold" for="sysToSI">Sistema Internacional (S.I.)</label>

                            <input type="radio" class="btn-check" name="sysTo" id="sysToIng" value="ING" checked onchange="filtrarUnidades()">
                            <label class="btn btn-outline-danger btn-sm fw-bold" for="sysToIng">Sistema Inglés</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <select class="form-select bg-dark text-white fw-bold" id="toUnit" onchange="ejecutarConversion()"></select>
                    </div>
                </div>

                <!-- Simulación Animada Interactivas -->
                <div class="col-md-7 text-center border-start border-secondary ps-4">
                    <h5 class="text-light fw-bold">Simulación Gráfica en Tiempo Real</h5>

                    <div id="visualCanvasContainer" class="my-2 p-2 rounded border border-secondary" style="background-color: #080c14 !important;">
                        <canvas id="unitCanvas" width="460" height="210"></canvas>
                        <p id="graphicLabel" class="text-info mt-1 fw-bold small mb-0"></p>
                    </div>

                    <div class="alert alert-success py-2 mb-2 bg-dark border-success">
                        <small class="d-block text-muted">Resultado de la Conversión:</small>
                        <h4 id="resultText" class="fw-bold mb-0 text-success">---</h4>
                    </div>

                    <button class="btn btn-outline-warning btn-sm w-100" type="button" data-bs-toggle="collapse" data-bs-target="#pasoConversion">
                        Mostrar / Ocultar Procedimiento Matemático
                    </button>

                    <div class="collapse mt-2" id="pasoConversion">
                        <div class="card card-body bg-black text-white p-3 small border border-warning text-start" id="procedureText" style="font-family: monospace;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const canvasUnit = document.getElementById('unitCanvas');
    const ctxU = canvasUnit.getContext('2d');
    let animId = null;
    let animStep = 0;

    // Catálogo exacto del manual dividido de forma independiente entre S.I. e Inglés
    const unitCatalog = {
        longitud: {
            SI: [
                {id:'m', label:'Metros (m)'},
                {id:'cm', label:'Centímetros (cm)'},
                {id:'mm', label:'Milímetros (mm)'},
                {id:'um', label:'Micrómetros (µm)'},
                {id:'nm', label:'Nanómetros (nm)'},
                {id:'km', label:'Kilómetros (km)'}
            ],
            ING: [
                {id:'ft', label:'Pies (ft)'},
                {id:'in', label:'Pulgadas (in)'},
                {id:'yd', label:'Yardas (yd)'},
                {id:'mi', label:'Millas (mi)'},
                {id:'milla_nautica', label:'Milla Náutica'}
            ]
        },
        area: {
            SI: [
                {id:'m2', label:'Metros² (m²)'},
                {id:'cm2', label:'Centímetros² (cm²)'}
            ],
            ING: [
                {id:'ft2', label:'Pies² (ft²)'},
                {id:'in2', label:'Pulgadas² (in²)'},
                {id:'acre', label:'Acres'},
                {id:'mi2', label:'Millas² (mi²)'}
            ]
        },
        volumen: {
            SI: [
                {id:'lt', label:'Litros (lt)'},
                {id:'m3', label:'Metros³ (m³)'},
                {id:'cm3', label:'Centímetros³ (cm³)'},
                {id:'ml', label:'Mililitros (ml)'}
            ],
            ING: [
                {id:'ft3', label:'Pies³ (ft³)'},
                {id:'gal', label:'Galones (gal)'},
                {id:'oz', label:'Onzas Fluidas (onz)'}
            ]
        },
        tiempo: {
            SI: [
                {id:'s', label:'Segundos (s)'},
                {id:'min', label:'Minutos (min)'},
                {id:'h', label:'Horas (h)'},
                {id:'d', label:'Días (d)'},
                {id:'ano', label:'Años (año)'}
            ],
            ING: [
                {id:'s', label:'Segundos (s)'},
                {id:'min', label:'Minutos (min)'},
                {id:'h', label:'Horas (h)'},
                {id:'d', label:'Días (d)'},
                {id:'ano', label:'Años (año)'}
            ]
        },
        angulo: {
            SI: [
                {id:'rad', label:'Radianes (rad)'},
                {id:'deg', label:'Grados (°)'}
            ],
            ING: [
                {id:'deg', label:'Grados (°)'},
                {id:'rev', label:'Revoluciones (rev)'}
            ]
        },
        velocidad: {
            SI: [
                {id:'m_s', label:'Metros/seg (m/s)'},
                {id:'km_h', label:'Kilómetros/hora (km/h)'}
            ],
            ING: [
                {id:'ft_s', label:'Pies/seg (ft/s)'},
                {id:'mi_h', label:'Millas/hora (mi/h)'}
            ]
        },
        aceleracion: {
            SI: [
                {id:'m_s2', label:'m/s²'},
                {id:'cm_s2', label:'cm/s²'}
            ],
            ING: [
                {id:'ft_s2', label:'ft/s²'}
            ]
        },
        masa: {
            SI: [
                {id:'kg', label:'Kilogramos (kg)'},
                {id:'g', label:'Gramos (g)'},
                {id:'mg', label:'Miligramos (mg)'}
            ],
            ING: [
                {id:'lb', label:'Libras (lb)'},
                {id:'slug', label:'Slugs (slug)'}
            ]
        },
        fuerza: {
            SI: [
                {id:'N', label:'Newtons (N)'},
                {id:'dyn', label:'Dinas (dyn)'}
            ],
            ING: [
                {id:'lb', label:'Libras fuerza (lb)'}
            ]
        },
        presion: {
            SI: [
                {id:'Pa', label:'Pascales (Pa)'},
                {id:'atm', label:'Atmósferas (atm)'},
                {id:'mmHg', label:'mmHg'}
            ],
            ING: [
                {id:'psi', label:'PSI (lb/in²)'},
                {id:'lb_ft2', label:'lb/ft²'}
            ]
        },
        energia: {
            SI: [
                {id:'J', label:'Joules (J)'},
                {id:'cal', label:'Calorías (cal)'},
                {id:'kWh', label:'Kilovatios-hora (kWh)'}
            ],
            ING: [
                {id:'Btu', label:'BTU'}
            ]
        },
        potencia: {
            SI: [
                {id:'W', label:'Watts (W)'}
            ],
            ING: [
                {id:'hp', label:'Caballos Fuerza (hp)'},
                {id:'Btu_h', label:'Btu/h'}
            ]
        },
        temperatura: {
            SI: [
                {id:'C', label:'Celsius (°C)'},
                {id:'K', label:'Kelvin (K)'}
            ],
            ING: [
                {id:'F', label:'Fahrenheit (°F)'}
            ]
        }
    };

    function cambiarMagnitud() {
        filtrarUnidades();
    }

    function filtrarUnidades() {
        const mag = document.getElementById('magnitudeSelect').value;
        const sysFrom = document.querySelector('input[name="sysFrom"]:checked').value;
        const sysTo = document.querySelector('input[name="sysTo"]:checked').value;

        const fromSelect = document.getElementById('fromUnit');
        const toSelect = document.getElementById('toUnit');

        fromSelect.innerHTML = '';
        toSelect.innerHTML = '';

        const unitsFrom = unitCatalog[mag][sysFrom] || [];
        const unitsTo = unitCatalog[mag][sysTo] || [];

        unitsFrom.forEach(u => {
            fromSelect.innerHTML += `<option value="${u.id}">${u.label}</option>`;
        });

        unitsTo.forEach(u => {
            toSelect.innerHTML += `<option value="${u.id}">${u.label}</option>`;
        });

        ejecutarConversion();
    }

    function ejecutarConversion() {
        const mag = document.getElementById('magnitudeSelect').value;
        const val = parseFloat(document.getElementById('inputValue').value) || 0;
        const from = document.getElementById('fromUnit').value;
        const to = document.getElementById('toUnit').value;

        if (!from || !to) return;

        fetch('/conversor-unidades/convertir', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ magnitude: mag, value: val, from_unit: from, to_unit: to })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('resultText').innerText = `${val} ${from} = ${data.result} ${to}`;

            let htmlProcedure = `<b>PROCEDIMIENTO DE CONVERSIÓN DE SISTEMAS:</b><br><br>`;
            htmlProcedure += `1. Cantidad Inicial: <b>${val} [${from}]</b><br>`;
            htmlProcedure += `2. Multiplicación por el Factor de Conversión:<br>`;
            htmlProcedure += `<div class="p-2 my-2 bg-dark border border-secondary text-center fw-bold text-warning">`;
            htmlProcedure += `${val} [${from}] × ( Factor de Conversión ) = ${data.result} [${to}]`;
            htmlProcedure += `</div>`;
            htmlProcedure += `3. Cancelación de unidades de origen y simplificación.<br>`;
            htmlProcedure += `<b>Resultado Final: ${data.result} ${to}</b>`;

            document.getElementById('procedureText').innerHTML = htmlProcedure;

            dibujarSimulacion(mag, val, data.result, from, to);
        });
    }

    function dibujarSimulacion(mag, val, resVal, fromUnit, toUnit) {
        if (animId) cancelAnimationFrame(animId);
        const w = canvasUnit.width;
        const h = canvasUnit.height;

        function loop() {
            animStep += 0.05;
            ctxU.clearRect(0, 0, w, h);

            if (mag === 'masa') {
                ctxU.fillStyle = '#334155';
                ctxU.fillRect(160, 170, 140, 15);
                ctxU.fillRect(220, 120, 20, 50);

                ctxU.fillStyle = '#d97706';
                ctxU.beginPath();
                ctxU.roundRect(175, 45, 110, 75, 12);
                ctxU.fill();

                ctxU.fillStyle = '#fef08a';
                ctxU.fillRect(185, 60, 90, 30);
                ctxU.fillStyle = '#000000';
                ctxU.font = 'bold 12px Arial';
                ctxU.fillText('ARROZ', 208, 80);

                ctxU.fillStyle = '#38bdf8';
                ctxU.font = 'bold 14px Arial';
                ctxU.fillText(`Masa: ${val} ${fromUnit}`, 180, 200);

            } else if (mag === 'velocidad' || mag === 'aceleracion') {
                ctxU.fillStyle = '#1e293b';
                ctxU.fillRect(0, 140, w, 40);

                let carPos = (animStep * Math.min(Math.max(val, 2), 20) * 10) % (w + 80) - 80;

                ctxU.fillStyle = '#ef4444';
                ctxU.beginPath();
                ctxU.roundRect(carPos, 115, 75, 25, 6);
                ctxU.fill();

                ctxU.fillStyle = '#000000';
                ctxU.beginPath();
                ctxU.arc(carPos + 18, 140, 8, 0, Math.PI * 2);
                ctxU.arc(carPos + 58, 140, 8, 0, Math.PI * 2);
                ctxU.fill();

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 13px Arial';
                ctxU.fillText(`Rapidez: ${val} ${fromUnit}`, 20, 30);

            } else if (mag === 'volumen') {
                ctxU.strokeStyle = '#94a3b8';
                ctxU.lineWidth = 3;
                ctxU.strokeRect(190, 30, 80, 150);

                let level = Math.min(Math.max(val * 1.5, 20), 140);
                ctxU.fillStyle = '#0284c7';
                ctxU.fillRect(192, 180 - level, 76, level);

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 13px Arial';
                ctxU.fillText(`Volumen: ${val} ${fromUnit}`, 290, 100);

            } else if (mag === 'temperatura') {
                ctxU.fillStyle = '#e2e8f0';
                ctxU.fillRect(215, 25, 30, 130);
                ctxU.beginPath();
                ctxU.arc(230, 155, 22, 0, Math.PI * 2);
                ctxU.fill();

                ctxU.fillStyle = '#dc2626';
                let tempH = Math.min(Math.max(val, 10), 110);
                ctxU.fillRect(223, 140 - tempH, 14, tempH);
                ctxU.beginPath();
                ctxU.arc(230, 155, 18, 0, Math.PI * 2);
                ctxU.fill();

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 13px Arial';
                ctxU.fillText(`Temp: ${val} ${fromUnit}`, 270, 90);

            } else if (mag === 'angulo') {
                ctxU.strokeStyle = '#38bdf8';
                ctxU.lineWidth = 3;
                ctxU.beginPath();
                ctxU.arc(w/2, h - 30, 110, Math.PI, 0);
                ctxU.stroke();

                let radAng = (val % 360) * Math.PI / 180;
                ctxU.strokeStyle = '#ef4444';
                ctxU.lineWidth = 4;
                ctxU.beginPath();
                ctxU.moveTo(w/2, h - 30);
                ctxU.lineTo(w/2 + 95 * Math.cos(-radAng), (h - 30) + 95 * Math.sin(-radAng));
                ctxU.stroke();

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 14px Arial';
                ctxU.fillText(`Ángulo: ${val} ${fromUnit}`, w/2 - 50, h - 5);

            } else if (mag === 'area') {
                let size = Math.min(Math.max(val * 2, 40), 130);
                ctxU.strokeStyle = '#38bdf8';
                ctxU.lineWidth = 2;
                ctxU.strokeRect(w/2 - size/2, h/2 - size/2, size, size);

                ctxU.fillStyle = 'rgba(56, 189, 248, 0.2)';
                ctxU.fillRect(w/2 - size/2, h/2 - size/2, size, size);

                ctxU.fillStyle = '#f59e0b';
                ctxU.font = 'bold 12px Arial';
                ctxU.fillText(`Área: ${val} ${fromUnit}`, w/2 - 40, h/2 + 5);

            } else if (mag === 'energia') {
                ctxU.fillStyle = '#334155';
                ctxU.fillRect(w/2 - 60, 110, 120, 60);

                ctxU.fillStyle = '#ef4444';
                ctxU.beginPath();
                ctxU.arc(w/2 - 20, 130 + Math.sin(animStep*2)*4, 15, 0, Math.PI*2);
                ctxU.arc(w/2 + 20, 130 + Math.cos(animStep*2)*4, 15, 0, Math.PI*2);
                ctxU.fill();

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 13px Arial';
                ctxU.fillText(`Energía: ${val} ${fromUnit}`, w/2 - 60, 190);

            } else if (mag === 'potencia') {
                ctxU.save();
                ctxU.translate(w/2 - 35, 90);
                ctxU.rotate(animStep);
                ctxU.fillStyle = '#64748b';
                ctxU.fillRect(-25, -25, 50, 50);
                ctxU.restore();

                ctxU.save();
                ctxU.translate(w/2 + 25, 115);
                ctxU.rotate(-animStep);
                ctxU.fillStyle = '#94a3b8';
                ctxU.fillRect(-20, -20, 40, 40);
                ctxU.restore();

                ctxU.fillStyle = '#38bdf8';
                ctxU.font = 'bold 13px Arial';
                ctxU.fillText(`Potencia: ${val} ${fromUnit}`, w/2 - 65, 180);

            } else if (mag === 'presion') {
                ctxU.strokeStyle = '#38bdf8';
                ctxU.lineWidth = 4;
                ctxU.beginPath();
                ctxU.arc(w/2, 100, 65, 0, Math.PI * 2);
                ctxU.stroke();

                let pAng = (val % 100) * (Math.PI / 50) + animStep * 0.1;
                ctxU.strokeStyle = '#ef4444';
                ctxU.lineWidth = 3;
                ctxU.beginPath();
                ctxU.moveTo(w/2, 100);
                ctxU.lineTo(w/2 + 50 * Math.cos(pAng), 100 + 50 * Math.sin(pAng));
                ctxU.stroke();

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 13px Arial';
                ctxU.fillText(`Presión: ${val} ${fromUnit}`, w/2 - 40, 190);

            } else if (mag === 'fuerza') {
                let stretch = Math.sin(animStep) * 10 + Math.min(val, 50);
                ctxU.strokeStyle = '#f59e0b';
                ctxU.lineWidth = 3;
                ctxU.beginPath();
                ctxU.moveTo(w/2, 20);
                for(let i=0; i<10; i++) {
                    ctxU.lineTo(i%2===0 ? w/2 - 15 : w/2 + 15, 20 + i * (8 + stretch/10));
                }
                ctxU.stroke();

                ctxU.fillStyle = '#64748b';
                ctxU.fillRect(w/2 - 30, 100 + stretch, 60, 40);

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 12px Arial';
                ctxU.fillText(`Fuerza`, w/2 - 20, 125 + stretch);

            } else if (mag === 'longitud') {
                ctxU.fillStyle = '#f59e0b';
                ctxU.fillRect(40, 80, w - 80, 50);

                ctxU.fillStyle = '#000000';
                for(let i = 50; i < w - 50; i += 15) {
                    ctxU.fillRect(i, 80, 2, 15);
                }

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 14px Arial';
                ctxU.fillText(`Longitud: ${val} ${fromUnit}`, 120, 160);

            } else {
                ctxU.strokeStyle = '#38bdf8';
                ctxU.lineWidth = 4;
                ctxU.beginPath();
                ctxU.arc(w/2, 100, 60, 0, Math.PI * 2);
                ctxU.stroke();

                let secAng = animStep * 2;
                ctxU.strokeStyle = '#ef4444';
                ctxU.beginPath();
                ctxU.moveTo(w/2, 100);
                ctxU.lineTo(w/2 + 45 * Math.cos(secAng), 100 + 45 * Math.sin(secAng));
                ctxU.stroke();

                ctxU.fillStyle = '#ffffff';
                ctxU.font = 'bold 14px Arial';
                ctxU.fillText(`Tiempo: ${val} ${fromUnit}`, w/2 - 40, 185);
            }

            animId = requestAnimationFrame(loop);
        }

        loop();
    }

    window.onload = function() {
        filtrarUnidades();
    };
</script>
@endsection