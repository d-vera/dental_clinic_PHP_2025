<?php
$pageTitle = 'Gestión de Médicos';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

requireLogin();

$conn = getConnection();

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $query = "DELETE FROM medicos WHERE id = $id";
    if ($conn->query($query)) {
        $success = "Médico eliminado exitosamente";
    } else {
        $error = "Error al eliminar el médico";
    }
}

$search = $_GET['search'] ?? '';
$searchQuery = '';
if (!empty($search)) {
    $search = escape($conn, $search);
    $searchQuery = " WHERE nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR especialidad LIKE '%$search%' OR email LIKE '%$search%'";
}

$query = "SELECT * FROM medicos $searchQuery ORDER BY fecha_registro DESC";
$result = $conn->query($query);
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="mb-0">
                <i class="bi bi-person-badge"></i> Gestión de Médicos
            </h1>
            <p class="text-muted">Administra la información de los médicos</p>
        </div>
        <div class="col-auto">
            <a href="create.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Nuevo Médico
            </a>
            <a href="report_pdf.php" class="btn btn-danger no-print" target="_blank">
                <i class="bi bi-file-pdf"></i> Reporte PDF
            </a>
            <button onclick="window.print()" class="btn btn-secondary no-print">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>

    <?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card mb-4 no-print">
        <div class="card-body">
            <form method="GET" action="" class="row g-3">
                <div class="col-md-10">
                    <div class="search-box">
                        <input type="text" class="form-control" name="search" id="searchInput" 
                               placeholder="Buscar por nombre, apellido, especialidad o email..." 
                               value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <i class="bi bi-search"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Especialidad</th>
                            <th>Cédula Profesional</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th class="no-print">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td>
                                    <?php if ($row['foto']): ?>
                                    <img src="/fourthBim/4. final_project/uploads/medicos/<?php echo htmlspecialchars($row['foto']); ?>" 
                                         class="profile-img-sm me-2" alt="Foto">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo htmlspecialchars($row['especialidad']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['cedula_profesional']); ?></td>
                                <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><small><?php echo htmlspecialchars($row['horario_atencion'] ?? 'N/A'); ?></small></td>
                                <td>
                                    <?php if ($row['activo']): ?>
                                    <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="no-print">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="view.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-info" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="?delete=<?php echo $row['id']; ?>" 
                                           class="btn btn-danger" title="Eliminar"
                                           onclick="return confirmarEliminacion('¿Está seguro de eliminar este médico?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">No se encontraron médicos</p>
                                    <a href="create.php" class="btn btn-success">
                                        <i class="bi bi-plus-circle"></i> Agregar Primer Médico
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($result && $result->num_rows > 0): ?>
            <div class="mt-3">
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle"></i> 
                    Total de médicos: <strong><?php echo $result->num_rows; ?></strong>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
closeConnection($conn);
require_once __DIR__ . '/../../includes/footer.php';
?>
