<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Física Pro - ITCA FEPADE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0f19; color: #e2e8f0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-custom { background-color: #161e2e; border-bottom: 2px solid #00b4d8; }
        .card-custom { background-color: #161e2e; border: 1px solid #2d3748; border-radius: 10px; }
        .form-control, .form-select { background-color: #0d131f; border: 1px solid #2d3748; color: #fff; }
        .form-control:focus, .form-select:focus { background-color: #131a29; color: #fff; border-color: #00b4d8; }

        /* Estilos responsivos del equipo */
        .card-perfil {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-perfil:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 180, 216, 0.3) !important;
        }
        .img-perfil-zoom {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .img-perfil-zoom:hover {
            transform: scale(1.08);
        }
    </style>
</head>
<body>
    <!-- BARRA DE NAVEGACIÓN PRINCIPAL RESPONSIVA -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 mb-4">
        <div class="container-fluid px-0">
            <a class="navbar-brand text-info fw-bold" href="/">🔬 SISTEMA WEB DE FÍSICA</a>
            
            <button class="navbar-toggler border-info" type="button" data-bs-toggle="collapse" data-bs-target="#navbarFisica" aria-controls="navbarFisica" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarFisica">
                <div class="navbar-nav ms-auto gap-2 pt-3 pt-lg-0">
                    <a class="nav-link btn btn-outline-info text-white px-3" href="/simulador-vectores">📐 Simulador de Vectores</a>
                    <a class="nav-link btn btn-outline-warning text-white px-3" href="/conversor-unidades">🔄 Conversor de Unidades Gráfico</a>
                    <a class="nav-link btn btn-outline-success text-white px-3" href="/actividades">🎮 Actividades Interactivas</a>
                    <a class="nav-link btn btn-outline-light text-info px-3" href="#equipo-desarrollo">👥 Equipo de Desarrollo</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL DE LOS SIMULADORES -->
    <div class="container-fluid px-4">
        @yield('content')
    </div>

    <!-- SECCIÓN DE NUESTRO EQUIPO (8 INTEGRANTES) -->
    <section class="container my-5" id="equipo-desarrollo">
        <div class="text-center mb-4">
            <h4 class="text-info fw-bold">👨‍💻 EQUIPO DE DESARROLLO Y CONSULTORÍA</h4>
            <p class="text-muted small">Haz clic en la foto de cualquier integrante para desplegarla en pantalla grande.</p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- INTEGRANTE 1: ALEXIS -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f1.jpeg') }}" alt="Alexis Alejandro Gonzales Guzman" 
                             class="rounded-circle border border-info mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f1.jpeg') }}', 'Alexis Alejandro Gonzales Guzman')">
                        <h6 class="fw-bold text-white mb-1">Alexis Alejandro Gonzales Guzman</h6>
                        <span class="badge bg-info text-dark mb-2">Líder & Full Stack</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Arquitectura Backend, Laravel & Canvas</li>
                            <li><strong>📍 Ubicación:</strong> San Juan Nonualco, La Paz</li>
                            <li><strong>✉️ Correo:</strong> @ejemplo.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Desarrollador Web enfocado en arquitectura de software y módulos interactivos.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INTEGRANTE 2: HEYDI -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f2.jpeg') }}" alt="Heydi Maricela Garcia Valladares" 
                             class="rounded-circle border border-warning mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f2.jpeg') }}', 'Heydi Maricela Garcia Valladares')">
                        <h6 class="fw-bold text-white mb-1">Heydi Maricela Garcia Valladares</h6>
                        <span class="badge bg-warning text-dark mb-2">Desarrollador Frontend</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Diseño UI/UX Responsivo</li>
                            <li><strong>📍 Ubicación:</strong> Zacatecoluca, La Paz</li>
                            <li><strong>✉️ Correo:</strong> heydygarcia94@gmail.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Especialista en maquetación responsiva y diseño web adaptable.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INTEGRANTE 3: MADELINE -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f3.jpeg') }}" alt="Madeline Marisol Rivera Rosales" 
                             class="rounded-circle border border-info mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f3.jpeg') }}', 'Madeline Marisol Rivera Rosales')">
                        <h6 class="fw-bold text-white mb-1">Madeline Marisol Rivera Rosales</h6>
                        <span class="badge bg-info text-dark mb-2">Base de Datos</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Modelado MySQL & C# Chart</li>
                            <li><strong>📍 Ubicación:</strong> San Luis Talpa, La Paz Oeste</li>
                            <li><strong>✉️ Correo:</strong> rosalesmarisol057@gmail.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Desarrollador enfocado en gestión de bases de datos relacionales.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INTEGRANTE 4: CORINA -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f4.jpeg') }}" alt="Corina Jamileth Ponce Fuentes" 
                             class="rounded-circle border border-warning mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f4.jpeg') }}', 'Corina Jamileth Ponce Fuentes')">
                        <h6 class="fw-bold text-white mb-1">Corina Jamileth Ponce Fuentes</h6>
                        <span class="badge bg-warning text-dark mb-2">Desarrollador QA</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Pruebas & Validación</li>
                            <li><strong>📍 Ubicación:</strong> Zacatecoluca, La Paz</li>
                            <li><strong>✉️ Correo:</strong> yamiponce820@gmail.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Encargado de validación técnica y pruebas de compatibilidad.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INTEGRANTE 5: MOISÉS -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f5.jpeg') }}" alt="Moises Adalberto Rivas Vargas" 
                             class="rounded-circle border border-info mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f5.jpeg') }}', 'Moises Adalberto Rivas Vargas')">
                        <h6 class="fw-bold text-white mb-1">Moises Adalberto Rivas Vargas</h6>
                        <span class="badge bg-info text-dark mb-2">Control de Versiones</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Gestión Git/GitHub</li>
                            <li><strong>📍 Ubicación:</strong> Zacatecoluca, La Paz</li>
                            <li><strong>✉️ Correo:</strong> mv732656@gmail.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Gestión de repositorios, documentación y control de cambios.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INTEGRANTE 6: AMY (PNG) -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f6.png') }}" alt="Amy Sarai Flores Aguilar" 
                             class="rounded-circle border border-warning mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f6.png') }}', 'Amy Sarai Flores Aguilar')">
                        <h6 class="fw-bold text-white mb-1">Amy Sarai Flores Aguilar</h6>
                        <span class="badge bg-warning text-dark mb-2">Soporte Técnico</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Despliegue de Servidores</li>
                            <li><strong>📍 Ubicación:</strong> El Salvador</li>
                            <li><strong>✉️ Correo:</strong> integrante6@ejemplo.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Especialista en configuración de entornos locales y servidores.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INTEGRANTE 7: JAIRO -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f7.jpeg') }}" alt="Jairo Ismael Marmol Martinez" 
                             class="rounded-circle border border-info mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f7.jpeg') }}', 'Jairo Ismael Marmol Martinez')">
                        <h6 class="fw-bold text-white mb-1">Jairo Ismael Marmol Martinez</h6>
                        <span class="badge bg-info text-dark mb-2">Documentación UI</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Redacción Técnica & Estructura</li>
                            <li><strong>📍 Ubicación:</strong>La Costa La paz</li>
                            <li><strong>✉️ Correo:</strong> jairomar373@gmail.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Encargado de la maquetación de informes y apoyo de interfaz.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INTEGRANTE 8: RENE -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary text-white h-100 shadow-sm card-perfil">
                    <div class="card-body text-center p-3">
                        <img src="{{ asset('img/equipo/f8.jpeg') }}" alt="Rene Alexander Avalos Guillen" 
                             class="rounded-circle border border-warning mb-3 shadow img-perfil-zoom" 
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #1e293b;"
                             data-bs-toggle="modal" data-bs-target="#modalFotoPerfil"
                             onclick="prepararModal('{{ asset('img/equipo/f8.jpeg') }}', 'Rene Alexander Avalos Guillen')">
                        <h6 class="fw-bold text-white mb-1">Rene Alexander Avalos Guillen</h6>
                        <span class="badge bg-warning text-dark mb-2">Asistente de Pruebas</span>
                        <ul class="list-unstyled text-start small text-light border-top border-secondary pt-2 mb-2" style="font-size: 0.8rem;">
                            <li><strong>🎓 Institución:</strong> Escuela Especializada en Ingeniería ITCA Zacatecoluca</li>
                            <li><strong>🛠️ Rol:</strong> Verificación de Módulos</li>
                            <li><strong>📍 Ubicación:</strong>La Costa La paz</li>
                            <li><strong>✉️ Correo:</strong> reneguillen109@gmail.com</li>
                        </ul>
                        <p class="card-text text-muted small text-start border-top border-secondary pt-2 m-0" style="font-size: 0.75rem;">
                            <strong>Perfil:</strong> Apoyo en desarrollo, revisión de código y maquetado responsivo.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- MODAL BOOTSTRAP PURAMENTE DECLARATIVO (SIN CONFLICTOS DE JAVASCRIPT) -->
    <div class="modal fade" id="modalFotoPerfil" tabindex="-1" aria-labelledby="modalFotoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border border-info shadow-lg">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-info fw-bold" id="modalFotoLabel">Fotografía de Integrante</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <img id="imgModalTarget" src="" class="img-fluid rounded border border-secondary shadow" style="max-height: 400px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <!-- ÚNICA INCLUSIÓN DE BOOTSTRAP JS AL FINAL DEL DOCUMENTO -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function prepararModal(urlImagen, nombreIntegrante) {
            document.getElementById('imgModalTarget').src = urlImagen;
            document.getElementById('modalFotoLabel').innerText = 'Fotografía de ' + nombreIntegrante;
        }
    </script>

    @yield('scripts')
</body>
</html>