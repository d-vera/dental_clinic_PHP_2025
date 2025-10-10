<?php
$pageTitle = 'Gestión de Pacientes';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Requerir login
requireLogin();

$conn = getConnection();

// Manejar eliminación
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $query = "DELETE FROM pacientes WHERE id = $id";
    if ($conn->query($query)) {
        $success = "Paciente eliminado exitosamente";
    } else {
        $error = "Error al eliminar el paciente";
    }
}

// Obtener término de búsqueda
$search = $_GET['search'] ?? '';
$searchQuery = '';
if (!empty($search)) {
    $search = escape($conn, $search);
    $searchQuery = " WHERE nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR email LIKE '%$search%' OR telefono LIKE '%$search%'";
}

// Obtener lista de pacientes
$query = "SELECT * FROM pacientes $searchQuery ORDER BY fecha_registro DESC";
$result = $conn->query($query);
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="mb-0">
                <i class="bi bi-people"></i> Gestión de Pacientes
            </h1>
            <p class="text-muted">Administra la información de los pacientes</p>
        </div>
        <div class="col-auto">
            <a href="create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Paciente
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

    <!-- Búsqueda -->
    <div class="card mb-4 no-print">
        <div class="card-body">
            <form method="GET" action="" class="row g-3">
                <div class="col-md-10">
                    <div class="search-box">
                        <input type="text" class="form-control" name="search" id="searchInput" 
                               placeholder="Buscar por nombre, apellido, email o teléfono..." 
                               value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <i class="bi bi-search"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de pacientes -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Edad</th>
                            <th>Género</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Tipo Sangre</th>
                            <th>Fecha Registro</th>
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
                                    <img src="/clinic/uploads/pacientes/<?php echo htmlspecialchars($row['foto']); ?>" 
                                         class="profile-img-sm me-2" alt="Foto">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?>
                                </td>
                                <td><?php echo $row['edad']; ?> años</td>
                                <td>
                                    <span class="badge bg-<?php echo $row['genero'] === 'Masculino' ? 'primary' : 'danger'; ?>">
                                        <?php echo $row['genero']; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php if ($row['tipo_sangre']): ?>
                                    <span class="badge bg-danger"><?php echo htmlspecialchars($row['tipo_sangre']); ?></span>
                                    <?php else: ?>
                                    N/A
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($row['fecha_registro'])); ?></td>
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
                                           onclick="return confirmarEliminacion('¿Está seguro de eliminar este paciente?')">
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
                                    <p class="text-muted mt-2">No se encontraron pacientes</p>
                                    <a href="create.php" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Agregar Primer Paciente
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
                    Total de pacientes: <strong><?php echo $result->num_rows; ?></strong>
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
