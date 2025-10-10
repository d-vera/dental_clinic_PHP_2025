<?php
$pageTitle = 'Ver Médico';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

requireLogin();

$conn = getConnection();
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM medicos WHERE id = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    $_SESSION['error'] = "Médico no encontrado";
    header("Location: index.php");
    exit();
}

$medico = $result->fetch_assoc();
?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="mb-0">
                <i class="bi bi-person-badge"></i> Detalles del Médico
            </h1>
        </div>
        <div class="col-auto">
            <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button onclick="window.print()" class="btn btn-info no-print">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <?php if ($medico['foto']): ?>
                    <img src="/clinic/uploads/medicos/<?php echo htmlspecialchars($medico['foto']); ?>" 
                         class="profile-img mb-3" alt="Foto del médico">
                    <?php else: ?>
                    <i class="bi bi-person-badge text-muted" style="font-size: 150px;"></i>
                    <?php endif; ?>
                    <h4><?php echo htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido']); ?></h4>
                    <p class="text-muted mb-2">ID: <?php echo $medico['id']; ?></p>
                    <span class="badge bg-info mb-2"><?php echo htmlspecialchars($medico['especialidad']); ?></span>
                    <br>
                    <?php if ($medico['activo']): ?>
                    <span class="badge bg-success">Activo</span>
                    <?php else: ?>
                    <span class="badge bg-secondary">Inactivo</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Cédula Profesional:</strong><br>
                            <?php echo htmlspecialchars($medico['cedula_profesional']); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Especialidad:</strong><br>
                            <span class="badge bg-info"><?php echo htmlspecialchars($medico['especialidad']); ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Teléfono:</strong><br>
                            <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($medico['telefono']); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong><br>
                            <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($medico['email']); ?>
                        </div>
                        <?php if ($medico['direccion']): ?>
                        <div class="col-12">
                            <strong>Dirección:</strong><br>
                            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($medico['direccion']); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-week"></i> Información Profesional</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Horario de Atención:</strong><br>
                        <?php if ($medico['horario_atencion']): ?>
                        <div class="alert alert-info mt-2 mb-0">
                            <i class="bi bi-clock"></i> <?php echo htmlspecialchars($medico['horario_atencion']); ?>
                        </div>
                        <?php else: ?>
                        <span class="text-muted">No especificado</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <strong>Estado:</strong><br>
                        <?php if ($medico['activo']): ?>
                        <span class="badge bg-success">Activo - Disponible para consultas</span>
                        <?php else: ?>
                        <span class="badge bg-secondary">Inactivo - No disponible</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-clock-history"></i> Información del Registro</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Fecha de Registro:</strong><br>
                    <?php echo date('d/m/Y H:i:s', strtotime($medico['fecha_registro'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
closeConnection($conn);
require_once __DIR__ . '/../../includes/footer.php';
?>
