<?php
$pageTitle = 'Nuevo Médico';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Solo administradores pueden crear médicos
requireAdmin();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getConnection();
    
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $especialidad = trim($_POST['especialidad'] ?? '');
    $cedula_profesional = trim($_POST['cedula_profesional'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $horario_atencion = trim($_POST['horario_atencion'] ?? '');
    $activo = isset($_POST['activo']) ? 1 : 0;
    
    if (empty($nombre)) $errors[] = "El nombre es requerido";
    if (empty($apellido)) $errors[] = "El apellido es requerido";
    if (empty($especialidad)) $errors[] = "La especialidad es requerida";
    if (empty($cedula_profesional)) $errors[] = "La cédula profesional es requerida";
    if (empty($telefono)) $errors[] = "El teléfono es requerido";
    if (empty($email)) $errors[] = "El email es requerido";
    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email no es válido";
    }
    
    // Verificar si la cédula ya existe
    if (!empty($cedula_profesional)) {
        $cedula_check = escape($conn, $cedula_profesional);
        $check_query = "SELECT id FROM medicos WHERE cedula_profesional = '$cedula_check'";
        $check_result = $conn->query($check_query);
        if ($check_result && $check_result->num_rows > 0) {
            $errors[] = "La cédula profesional ya está registrada";
        }
    }
    
    // Verificar si el email ya existe
    if (!empty($email)) {
        $email_check = escape($conn, $email);
        $check_query = "SELECT id FROM medicos WHERE email = '$email_check'";
        $check_result = $conn->query($check_query);
        if ($check_result && $check_result->num_rows > 0) {
            $errors[] = "El email ya está registrado";
        }
    }
    
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $newname = uniqid() . '.' . $ext;
            $upload_dir = __DIR__ . '/../../uploads/medicos/';
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_dir . $newname)) {
                $foto = $newname;
            }
        } else {
            $errors[] = "Solo se permiten imágenes JPG, JPEG, PNG o GIF";
        }
    }
    
    if (empty($errors)) {
        $nombre = escape($conn, $nombre);
        $apellido = escape($conn, $apellido);
        $especialidad = escape($conn, $especialidad);
        $cedula_profesional = escape($conn, $cedula_profesional);
        $telefono = escape($conn, $telefono);
        $email = escape($conn, $email);
        $direccion = escape($conn, $direccion);
        $horario_atencion = escape($conn, $horario_atencion);
        
        $query = "INSERT INTO medicos (nombre, apellido, especialidad, cedula_profesional, telefono, email, direccion, horario_atencion, foto, activo) 
                  VALUES ('$nombre', '$apellido', '$especialidad', '$cedula_profesional', '$telefono', '$email', " . 
                  ($direccion ? "'$direccion'" : "NULL") . ", " . 
                  ($horario_atencion ? "'$horario_atencion'" : "NULL") . ", " . 
                  ($foto ? "'$foto'" : "NULL") . ", $activo)";
        
        if ($conn->query($query)) {
            $_SESSION['success'] = "Médico creado exitosamente";
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Error al crear el médico: " . $conn->error;
        }
    }
    
    closeConnection($conn);
}
?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="mb-0">
                <i class="bi bi-person-plus-fill"></i> Nuevo Médico
            </h1>
            <p class="text-muted">Registra un nuevo médico en el sistema</p>
        </div>
        <div class="col-auto">
            <a href="index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6><i class="bi bi-exclamation-triangle"></i> Se encontraron los siguientes errores:</h6>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-12 mb-4">
                        <h5 class="border-bottom pb-2">
                            <i class="bi bi-person"></i> Información Personal
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese el nombre</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                               required value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese el apellido</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="especialidad" class="form-label">Especialidad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad" 
                               required placeholder="Ej: Cardiología, Pediatría, etc."
                               value="<?php echo htmlspecialchars($_POST['especialidad'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese la especialidad</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cedula_profesional" class="form-label">Cédula Profesional <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cedula_profesional" name="cedula_profesional" 
                               required placeholder="Ej: MED-12345"
                               value="<?php echo htmlspecialchars($_POST['cedula_profesional'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese la cédula profesional</div>
                    </div>

                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom pb-2">
                            <i class="bi bi-telephone"></i> Información de Contacto
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                               required placeholder="7XXXXXXX" pattern="[0-9]{8}" maxlength="8"
                               value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese un teléfono válido (8 dígitos)</div>
                        <small class="text-muted">Formato: 8 dígitos (ej: 71234567)</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               required placeholder="ejemplo@email.com"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese un email válido</div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" 
                                  rows="2"><?php echo htmlspecialchars($_POST['direccion'] ?? ''); ?></textarea>
                    </div>

                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom pb-2">
                            <i class="bi bi-calendar-week"></i> Información Profesional
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="horario_atencion" class="form-label">Horario de Atención</label>
                        <input type="text" class="form-control" id="horario_atencion" name="horario_atencion" 
                               placeholder="Ej: Lun-Vie 8:00-16:00"
                               value="<?php echo htmlspecialchars($_POST['horario_atencion'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="foto" class="form-label">Foto del Médico</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG, GIF</small>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                                   <?php echo (isset($_POST['activo']) || !isset($_POST['nombre'])) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="activo">
                                Médico activo (disponible para consultas)
                            </label>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Guardar Médico
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
