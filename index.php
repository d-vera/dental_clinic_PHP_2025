<?php
$pageTitle = 'Inicio';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/database.php';

// Obtener estadísticas si está logueado
$stats = [
    'pacientes' => 0,
    'medicos' => 0,
    'citas_hoy' => 0
];

if (isLoggedIn()) {
    $conn = getConnection();
    
    // Contar pacientes
    $result = $conn->query("SELECT COUNT(*) as total FROM pacientes");
    if ($result) {
        $stats['pacientes'] = $result->fetch_assoc()['total'];
    }
    
    // Contar médicos activos
    $result = $conn->query("SELECT COUNT(*) as total FROM medicos WHERE activo = 1");
    if ($result) {
        $stats['medicos'] = $result->fetch_assoc()['total'];
    }
    
    // Contar citas de hoy
    $result = $conn->query("SELECT COUNT(*) as total FROM citas WHERE DATE(fecha_cita) = CURDATE()");
    if ($result) {
        $stats['citas_hoy'] = $result->fetch_assoc()['total'];
    }
    
    closeConnection($conn);
}
?>

<div class="container">
    <!-- Hero Section -->
    <div class="hero-section text-center fade-in">
        <h1 class="display-4 fw-bold mb-3">
            <i class="bi bi-hospital"></i> Bienvenido a Clínica Médica
        </h1>
        <p class="lead mb-4">
            Sistema integral de gestión médica para el cuidado de tu salud
        </p>
        <?php if (!isLoggedIn()): ?>
        <a href="login.php" class="btn btn-light btn-lg">
            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
        </a>
        <?php endif; ?>
    </div>

    <?php if (isLoggedIn()): ?>
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people text-primary card-icon"></i>
                    <h3 class="mb-0"><?php echo $stats['pacientes']; ?></h3>
                    <p class="text-muted mb-0">Pacientes Registrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card success h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge text-success card-icon"></i>
                    <h3 class="mb-0"><?php echo $stats['medicos']; ?></h3>
                    <p class="text-muted mb-0">Médicos Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card warning h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-check text-warning card-icon"></i>
                    <h3 class="mb-0"><?php echo $stats['citas_hoy']; ?></h3>
                    <p class="text-muted mb-0">Citas Hoy</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Módulos del Sistema -->
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <h2 class="text-center mb-4">
                <i class="bi bi-grid-3x3-gap"></i> Módulos del Sistema
            </h2>
        </div>

        <?php if (isLoggedIn()): ?>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people text-primary card-icon"></i>
                    <h5 class="card-title">Pacientes</h5>
                    <p class="card-text">Gestión completa de pacientes y su historial médico</p>
                    <a href="pages/pacientes/index.php" class="btn btn-primary">
                        <i class="bi bi-arrow-right"></i> Acceder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-person-badge text-success card-icon"></i>
                    <h5 class="card-title">Médicos</h5>
                    <p class="card-text">Administración de médicos y especialidades</p>
                    <a href="pages/medicos/index.php" class="btn btn-success">
                        <i class="bi bi-arrow-right"></i> Acceder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-heart-pulse text-danger card-icon"></i>
                    <h5 class="card-title">Servicios</h5>
                    <p class="card-text">Servicios médicos disponibles en nuestra clínica</p>
                    <a href="pages/servicios.php" class="btn btn-danger">
                        <i class="bi bi-arrow-right"></i> Ver Servicios
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="col-lg-2"></div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-heart-pulse text-danger card-icon"></i>
                    <h5 class="card-title">Servicios</h5>
                    <p class="card-text">Conoce nuestros servicios médicos especializados</p>
                    <a href="pages/servicios.php" class="btn btn-danger">
                        <i class="bi bi-arrow-right"></i> Ver Servicios
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-envelope text-info card-icon"></i>
                    <h5 class="card-title">Contacto</h5>
                    <p class="card-text">Contáctanos para más información</p>
                    <a href="pages/contacto.php" class="btn btn-info">
                        <i class="bi bi-arrow-right"></i> Contactar
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
        <?php endif; ?>
    </div>

    <!-- Información adicional -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-info-circle text-primary"></i> Acerca de Nosotros
                    </h5>
                    <p class="card-text">
                        Clínica Médica es un centro de salud comprometido con brindar atención médica 
                        de calidad a todos nuestros pacientes. Contamos con profesionales altamente 
                        capacitados y tecnología de punta para garantizar el mejor servicio.
                    </p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success"></i> Atención personalizada</li>
                        <li><i class="bi bi-check-circle text-success"></i> Médicos especializados</li>
                        <li><i class="bi bi-check-circle text-success"></i> Tecnología moderna</li>
                        <li><i class="bi bi-check-circle text-success"></i> Horarios flexibles</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-clock text-warning"></i> Horarios de Atención
                    </h5>
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><strong>Lunes - Viernes</strong></td>
                                <td>7:00 AM - 8:00 PM</td>
                            </tr>
                            <tr>
                                <td><strong>Sábados</strong></td>
                                <td>8:00 AM - 4:00 PM</td>
                            </tr>
                            <tr>
                                <td><strong>Domingos</strong></td>
                                <td>9:00 AM - 2:00 PM</td>
                            </tr>
                            <tr>
                                <td><strong>Emergencias</strong></td>
                                <td class="text-danger"><strong>24/7</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-telephone"></i> <strong>Emergencias:</strong> +1 (809) 555-0911
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
