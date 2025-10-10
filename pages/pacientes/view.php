<?php
$pageTitle = 'Ver Paciente';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

requireLogin();

$conn = getConnection();
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM pacientes WHERE id = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    $_SESSION['error'] = "Paciente no encontrado";
    header("Location: index.php");
    exit();
}

$paciente = $result->fetch_assoc();
?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="mb-0">
                <i class="bi bi-person-circle"></i> Detalles del Paciente
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
                    <?php if ($paciente['foto']): ?>
                    <img src="/clinic/uploads/pacientes/<?php echo htmlspecialchars($paciente['foto']); ?>" 
                         class="profile-img mb-3" alt="Foto del paciente">
                    <?php else: ?>
                    <i class="bi bi-person-circle text-muted" style="font-size: 150px;"></i>
                    <?php endif; ?>
                    <h4><?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?></h4>
                    <p class="text-muted mb-2">ID: <?php echo $paciente['id']; ?></p>
                    <span class="badge bg-<?php echo $paciente['genero'] === 'Masculino' ? 'primary' : 'danger'; ?> mb-2">
                        <?php echo $paciente['genero']; ?>
                    </span>
                    <?php if ($paciente['tipo_sangre']): ?>
                    <br><span class="badge bg-danger"><?php echo htmlspecialchars($paciente['tipo_sangre']); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Fecha de Nacimiento:</strong><br>
                            <?php echo date('d/m/Y', strtotime($paciente['fecha_nacimiento'])); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Edad:</strong><br>
                            <?php echo $paciente['edad']; ?> años
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Teléfono:</strong><br>
                            <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($paciente['telefono']); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong><br>
                            <?php if ($paciente['email']): ?>
                            <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($paciente['email']); ?>
                            <?php else: ?>
                            <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <strong>Dirección:</strong><br>
                            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($paciente['direccion']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-heart-pulse"></i> Información Médica</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Alergias:</strong><br>
                        <?php if ($paciente['alergias']): ?>
                        <div class="alert alert-warning mt-2">
                            <i class="bi bi-exclamation-triangle"></i> <?php echo nl2br(htmlspecialchars($paciente['alergias'])); ?>
                        </div>
                        <?php else: ?>
                        <span class="text-muted">Sin alergias registradas</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <strong>Historial Médico:</strong><br>
                        <?php if ($paciente['historial_medico']): ?>
                        <div class="mt-2">
                            <?php echo nl2br(htmlspecialchars($paciente['historial_medico'])); ?>
                        </div>
                        <?php else: ?>
                        <span class="text-muted">Sin historial médico registrado</span>
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
                    <?php echo date('d/m/Y H:i:s', strtotime($paciente['fecha_registro'])); ?>
                </div>
                <div class="col-md-6">
                    <strong>Última Actualización:</strong><br>
                    <?php echo date('d/m/Y H:i:s', strtotime($paciente['ultima_actualizacion'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
closeConnection($conn);
require_once __DIR__ . '/../../includes/footer.php';
?>
