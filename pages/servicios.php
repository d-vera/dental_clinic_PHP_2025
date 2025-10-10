<?php
$pageTitle = 'Servicios Médicos';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <div class="row mb-4">
        <div class="col text-center">
            <h1 class="display-4 mb-3">
                <i class="bi bi-heart-pulse"></i> Nuestros Servicios Médicos
            </h1>
            <p class="lead text-muted">Ofrecemos una amplia gama de servicios médicos especializados</p>
        </div>
    </div>

    <div class="row">
        <!-- Servicio 1: Cardiología -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-heart-pulse text-danger" style="font-size: 4rem;"></i>
                    <h4 class="card-title mt-3">Cardiología</h4>
                    <p class="card-text">
                        Diagnóstico y tratamiento de enfermedades cardiovasculares. Contamos con 
                        equipos de última generación para electrocardiogramas, ecocardiogramas y 
                        pruebas de esfuerzo.
                    </p>
                    <ul class="list-unstyled text-start">
                        <li><i class="bi bi-check-circle text-success"></i> Electrocardiogramas</li>
                        <li><i class="bi bi-check-circle text-success"></i> Ecocardiogramas</li>
                        <li><i class="bi bi-check-circle text-success"></i> Holter 24 horas</li>
                        <li><i class="bi bi-check-circle text-success"></i> Pruebas de esfuerzo</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Servicio 2: Pediatría -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-emoji-smile text-primary" style="font-size: 4rem;"></i>
                    <h4 class="card-title mt-3">Pediatría</h4>
                    <p class="card-text">
                        Atención integral para niños desde recién nacidos hasta adolescentes. 
                        Control de crecimiento, vacunación y tratamiento de enfermedades infantiles.
                    </p>
                    <ul class="list-unstyled text-start">
                        <li><i class="bi bi-check-circle text-success"></i> Control de niño sano</li>
                        <li><i class="bi bi-check-circle text-success"></i> Vacunación completa</li>
                        <li><i class="bi bi-check-circle text-success"></i> Consultas de urgencia</li>
                        <li><i class="bi bi-check-circle text-success"></i> Seguimiento nutricional</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Servicio 3: Medicina General -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-hospital text-success" style="font-size: 4rem;"></i>
                    <h4 class="card-title mt-3">Medicina General</h4>
                    <p class="card-text">
                        Atención médica integral para toda la familia. Diagnóstico, tratamiento 
                        y prevención de enfermedades comunes.
                    </p>
                    <ul class="list-unstyled text-start">
                        <li><i class="bi bi-check-circle text-success"></i> Consultas generales</li>
                        <li><i class="bi bi-check-circle text-success"></i> Chequeos preventivos</li>
                        <li><i class="bi bi-check-circle text-success"></i> Certificados médicos</li>
                        <li><i class="bi bi-check-circle text-success"></i> Control de crónicos</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Servicio 4: Dermatología -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-droplet text-info" style="font-size: 4rem;"></i>
                    <h4 class="card-title mt-3">Dermatología</h4>
                    <p class="card-text">
                        Cuidado especializado de la piel, cabello y uñas. Tratamiento de 
                        enfermedades dermatológicas y procedimientos estéticos.
                    </p>
                    <ul class="list-unstyled text-start">
                        <li><i class="bi bi-check-circle text-success"></i> Consulta dermatológica</li>
                        <li><i class="bi bi-check-circle text-success"></i> Tratamiento de acné</li>
                        <li><i class="bi bi-check-circle text-success"></i> Dermatología estética</li>
                        <li><i class="bi bi-check-circle text-success"></i> Cirugía menor</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Servicio 5: Laboratorio Clínico -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard2-pulse text-warning" style="font-size: 4rem;"></i>
                    <h4 class="card-title mt-3">Laboratorio Clínico</h4>
                    <p class="card-text">
                        Análisis clínicos completos con resultados rápidos y confiables. 
                        Equipos modernos y personal altamente capacitado.
                    </p>
                    <ul class="list-unstyled text-start">
                        <li><i class="bi bi-check-circle text-success"></i> Análisis de sangre</li>
                        <li><i class="bi bi-check-circle text-success"></i> Análisis de orina</li>
                        <li><i class="bi bi-check-circle text-success"></i> Perfil lipídico</li>
                        <li><i class="bi bi-check-circle text-success"></i> Pruebas hormonales</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Servicio 6: Emergencias -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-danger">
                <div class="card-body text-center">
                    <i class="bi bi-ambulance text-danger" style="font-size: 4rem;"></i>
                    <h4 class="card-title mt-3">Emergencias 24/7</h4>
                    <p class="card-text">
                        Atención de emergencias las 24 horas del día, los 7 días de la semana. 
                        Personal médico disponible para cualquier urgencia.
                    </p>
                    <ul class="list-unstyled text-start">
                        <li><i class="bi bi-check-circle text-success"></i> Atención inmediata</li>
                        <li><i class="bi bi-check-circle text-success"></i> Sala de emergencias</li>
                        <li><i class="bi bi-check-circle text-success"></i> Ambulancia disponible</li>
                        <li><i class="bi bi-check-circle text-success"></i> Personal especializado</li>
                    </ul>
                    <div class="alert alert-danger mt-3 mb-0">
                        <strong><i class="bi bi-telephone-fill"></i> Emergencias:</strong><br>
                        <h4 class="mb-0">809-555-0911</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h4><i class="bi bi-calendar-check"></i> Agenda tu Cita</h4>
                    <p>
                        Agenda tu cita médica de forma fácil y rápida. Contamos con horarios 
                        flexibles para adaptarnos a tus necesidades.
                    </p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-telephone"></i> Teléfono: +1 (809) 555-0100</li>
                        <li><i class="bi bi-envelope"></i> Email: citas@clinicamedica.com</li>
                        <li><i class="bi bi-whatsapp"></i> WhatsApp: +1 (809) 555-0100</li>
                    </ul>
                    <?php if (isLoggedIn()): ?>
                    <a href="/fourthBim/4. final_project/pages/contacto.php" class="btn btn-light">
                        <i class="bi bi-calendar-plus"></i> Solicitar Cita
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h4><i class="bi bi-shield-check"></i> Seguros Médicos</h4>
                    <p>
                        Aceptamos los principales seguros médicos del país. Consulta con tu 
                        aseguradora para conocer tu cobertura.
                    </p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check2"></i> ARS Humano</li>
                        <li><i class="bi bi-check2"></i> ARS Palic</li>
                        <li><i class="bi bi-check2"></i> ARS Universal</li>
                        <li><i class="bi bi-check2"></i> Seguros Reservas</li>
                        <li><i class="bi bi-check2"></i> Y muchos más...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row mt-4 mb-4">
        <div class="col">
            <div class="card bg-light">
                <div class="card-body text-center py-5">
                    <h2 class="mb-3">¿Necesitas más información?</h2>
                    <p class="lead mb-4">
                        Nuestro equipo está disponible para responder todas tus preguntas
                    </p>
                    <a href="contacto.php" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-envelope"></i> Contáctanos
                    </a>
                    <?php if (!isLoggedIn()): ?>
                    <a href="/fourthBim/4. final_project/login.php" class="btn btn-success btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
