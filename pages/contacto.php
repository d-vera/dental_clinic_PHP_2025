<?php
$pageTitle = 'Contacto';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$success = '';
$errors = [];

// Procesar formulario de contacto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    
    // Validaciones
    if (empty($nombre)) $errors[] = "El nombre es requerido";
    if (empty($email)) $errors[] = "El email es requerido";
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email no es válido";
    }
    if (empty($telefono)) $errors[] = "El teléfono es requerido";
    if (empty($asunto)) $errors[] = "El asunto es requerido";
    if (empty($mensaje)) $errors[] = "El mensaje es requerido";
    
    if (empty($errors)) {
        // En un sistema real, aquí se enviaría un email o se guardaría en la base de datos
        $success = "¡Gracias por contactarnos! Tu mensaje ha sido enviado exitosamente. Nos pondremos en contacto contigo pronto.";
        
        // Limpiar campos después del envío exitoso
        $_POST = [];
    }
}
?>

<div class="container">
    <div class="row mb-4">
        <div class="col text-center">
            <h1 class="display-4 mb-3">
                <i class="bi bi-envelope"></i> Contáctanos
            </h1>
            <p class="lead text-muted">Estamos aquí para ayudarte. Envíanos tu mensaje</p>
        </div>
    </div>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h5><i class="bi bi-check-circle"></i> ¡Mensaje Enviado!</h5>
        <p class="mb-0"><?php echo htmlspecialchars($success); ?></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6><i class="bi bi-exclamation-triangle"></i> Por favor, corrige los siguientes errores:</h6>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulario de Contacto -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Envíanos un Mensaje</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                                <div class="invalid-feedback">Por favor, ingrese su nombre</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                <div class="invalid-feedback">Por favor, ingrese un email válido</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                       required placeholder="809-555-0100"
                                       value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                                <div class="invalid-feedback">Por favor, ingrese su teléfono</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="asunto" class="form-label">Asunto <span class="text-danger">*</span></label>
                                <select class="form-select" id="asunto" name="asunto" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Cita Médica" <?php echo (($_POST['asunto'] ?? '') === 'Cita Médica') ? 'selected' : ''; ?>>Solicitar Cita Médica</option>
                                    <option value="Información" <?php echo (($_POST['asunto'] ?? '') === 'Información') ? 'selected' : ''; ?>>Solicitar Información</option>
                                    <option value="Resultados" <?php echo (($_POST['asunto'] ?? '') === 'Resultados') ? 'selected' : ''; ?>>Consultar Resultados</option>
                                    <option value="Sugerencia" <?php echo (($_POST['asunto'] ?? '') === 'Sugerencia') ? 'selected' : ''; ?>>Sugerencia</option>
                                    <option value="Queja" <?php echo (($_POST['asunto'] ?? '') === 'Queja') ? 'selected' : ''; ?>>Queja</option>
                                    <option value="Otro" <?php echo (($_POST['asunto'] ?? '') === 'Otro') ? 'selected' : ''; ?>>Otro</option>
                                </select>
                                <div class="invalid-feedback">Por favor, seleccione un asunto</div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="mensaje" class="form-label">Mensaje <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="mensaje" name="mensaje" 
                                          rows="5" required 
                                          placeholder="Escribe tu mensaje aquí..."><?php echo htmlspecialchars($_POST['mensaje'] ?? ''); ?></textarea>
                                <div class="invalid-feedback">Por favor, ingrese su mensaje</div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send"></i> Enviar Mensaje
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="col-lg-5 mb-4">
            <!-- Datos de Contacto -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información de Contacto</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="bi bi-geo-alt-fill text-danger"></i> Dirección</h6>
                        <p class="mb-0">Av. Independencia #123<br>Santo Domingo, República Dominicana</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h6><i class="bi bi-telephone-fill text-primary"></i> Teléfonos</h6>
                        <p class="mb-1"><strong>Principal:</strong> +1 (809) 555-0100</p>
                        <p class="mb-1"><strong>Emergencias:</strong> +1 (809) 555-0911</p>
                        <p class="mb-0"><strong>WhatsApp:</strong> +1 (809) 555-0100</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h6><i class="bi bi-envelope-fill text-info"></i> Emails</h6>
                        <p class="mb-1"><strong>General:</strong> info@clinicamedica.com</p>
                        <p class="mb-0"><strong>Citas:</strong> citas@clinicamedica.com</p>
                    </div>
                    <hr>
                    <div>
                        <h6><i class="bi bi-clock-fill text-warning"></i> Horarios</h6>
                        <p class="mb-1"><strong>Lun - Vie:</strong> 7:00 AM - 8:00 PM</p>
                        <p class="mb-1"><strong>Sábados:</strong> 8:00 AM - 4:00 PM</p>
                        <p class="mb-1"><strong>Domingos:</strong> 9:00 AM - 2:00 PM</p>
                        <p class="mb-0"><strong>Emergencias:</strong> <span class="text-danger">24/7</span></p>
                    </div>
                </div>
            </div>

            <!-- Redes Sociales -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-share"></i> Síguenos</h5>
                </div>
                <div class="card-body text-center">
                    <a href="#" class="btn btn-primary btn-lg m-2">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-info btn-lg m-2">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-lg m-2">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-success btn-lg m-2">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa (Placeholder) -->
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-map"></i> Ubicación</h5>
                </div>
                <div class="card-body p-0">
                    <div class="ratio ratio-21x9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3784.3087445935!2d-69.93138368509!3d18.47186998744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8eaf89f0c3c1e5b5%3A0x7a9b5c8d6e4f3a2b!2sSanto%20Domingo%2C%20Dominican%20Republic!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preguntas Frecuentes -->
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="bi bi-question-circle"></i> Preguntas Frecuentes</h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    ¿Cómo puedo agendar una cita?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Puedes agendar tu cita llamando al (809) 555-0100, enviando un WhatsApp al mismo número, 
                                    o enviando un correo a citas@clinicamedica.com. También puedes usar este formulario de contacto.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    ¿Aceptan seguros médicos?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Sí, aceptamos los principales seguros médicos del país incluyendo ARS Humano, ARS Palic, 
                                    ARS Universal, Seguros Reservas y muchos más. Consulta con tu aseguradora para conocer tu cobertura.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    ¿Tienen servicio de emergencias?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Sí, contamos con servicio de emergencias 24/7. Para emergencias, llama al (809) 555-0911 
                                    o acude directamente a nuestra sala de emergencias.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
