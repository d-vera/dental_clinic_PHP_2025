<?php
$pageTitle = 'Nuevo Paciente';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

requireLogin();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getConnection();
    
    // Validación backend
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $edad = (int)($_POST['edad'] ?? 0);
    $genero = $_POST['genero'] ?? '';
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $tipo_sangre = trim($_POST['tipo_sangre'] ?? '');
    $alergias = trim($_POST['alergias'] ?? '');
    $historial_medico = trim($_POST['historial_medico'] ?? '');
    
    // Validaciones
    if (empty($nombre)) $errors[] = "El nombre es requerido";
    if (empty($apellido)) $errors[] = "El apellido es requerido";
    if (empty($fecha_nacimiento)) $errors[] = "La fecha de nacimiento es requerida";
    if ($edad <= 0) $errors[] = "La edad debe ser mayor a 0";
    if (empty($genero)) $errors[] = "El género es requerido";
    if (empty($telefono)) $errors[] = "El teléfono es requerido";
    if (empty($direccion)) $errors[] = "La dirección es requerida";
    
    // Validar email si se proporciona
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email no es válido";
    }
    
    // Manejar foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $newname = uniqid() . '.' . $ext;
            $upload_dir = __DIR__ . '/../../uploads/pacientes/';
            
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
    
    // Si no hay errores, insertar
    if (empty($errors)) {
        $nombre = escape($conn, $nombre);
        $apellido = escape($conn, $apellido);
        $fecha_nacimiento = escape($conn, $fecha_nacimiento);
        $genero = escape($conn, $genero);
        $telefono = escape($conn, $telefono);
        $email = escape($conn, $email);
        $direccion = escape($conn, $direccion);
        $tipo_sangre = escape($conn, $tipo_sangre);
        $alergias = escape($conn, $alergias);
        $historial_medico = escape($conn, $historial_medico);
        
        $query = "INSERT INTO pacientes (nombre, apellido, fecha_nacimiento, edad, genero, telefono, email, direccion, tipo_sangre, alergias, historial_medico, foto) 
                  VALUES ('$nombre', '$apellido', '$fecha_nacimiento', $edad, '$genero', '$telefono', " . 
                  ($email ? "'$email'" : "NULL") . ", '$direccion', " . 
                  ($tipo_sangre ? "'$tipo_sangre'" : "NULL") . ", " . 
                  ($alergias ? "'$alergias'" : "NULL") . ", " . 
                  ($historial_medico ? "'$historial_medico'" : "NULL") . ", " . 
                  ($foto ? "'$foto'" : "NULL") . ")";
        
        if ($conn->query($query)) {
            $_SESSION['success'] = "Paciente creado exitosamente";
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Error al crear el paciente: " . $conn->error;
        }
    }
    
    closeConnection($conn);
}
?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="mb-0">
                <i class="bi bi-person-plus"></i> Nuevo Paciente
            </h1>
            <p class="text-muted">Registra un nuevo paciente en el sistema</p>
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
                    <!-- Información Personal -->
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

                    <div class="col-md-4 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" 
                               required max="<?php echo date('Y-m-d'); ?>" 
                               value="<?php echo htmlspecialchars($_POST['fecha_nacimiento'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese la fecha de nacimiento</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="edad" class="form-label">Edad <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edad" name="edad" 
                               required min="0" max="150" readonly
                               value="<?php echo htmlspecialchars($_POST['edad'] ?? ''); ?>">
                        <div class="invalid-feedback">La edad se calcula automáticamente</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="genero" class="form-label">Género <span class="text-danger">*</span></label>
                        <select class="form-select" id="genero" name="genero" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino" <?php echo (($_POST['genero'] ?? '') === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Femenino" <?php echo (($_POST['genero'] ?? '') === 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                            <option value="Otro" <?php echo (($_POST['genero'] ?? '') === 'Otro') ? 'selected' : ''; ?>>Otro</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione el género</div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom pb-2">
                            <i class="bi bi-telephone"></i> Información de Contacto
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                               required placeholder="809-555-0100"
                               value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese el teléfono</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="ejemplo@email.com"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        <div class="invalid-feedback">Por favor, ingrese un email válido</div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="direccion" name="direccion" 
                                  rows="2" required><?php echo htmlspecialchars($_POST['direccion'] ?? ''); ?></textarea>
                        <div class="invalid-feedback">Por favor, ingrese la dirección</div>
                    </div>

                    <!-- Información Médica -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom pb-2">
                            <i class="bi bi-heart-pulse"></i> Información Médica
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tipo_sangre" class="form-label">Tipo de Sangre</label>
                        <select class="form-select" id="tipo_sangre" name="tipo_sangre">
                            <option value="">Seleccione...</option>
                            <?php
                            $tipos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                            foreach ($tipos as $tipo) {
                                $selected = (($_POST['tipo_sangre'] ?? '') === $tipo) ? 'selected' : '';
                                echo "<option value='$tipo' $selected>$tipo</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="foto" class="form-label">Foto del Paciente</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG, GIF</small>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="alergias" class="form-label">Alergias</label>
                        <textarea class="form-control" id="alergias" name="alergias" 
                                  rows="2" placeholder="Ej: Penicilina, Polen, etc."><?php echo htmlspecialchars($_POST['alergias'] ?? ''); ?></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="historial_medico" class="form-label">Historial Médico</label>
                        <textarea class="form-control" id="historial_medico" name="historial_medico" 
                                  rows="3" placeholder="Enfermedades previas, cirugías, tratamientos, etc."><?php echo htmlspecialchars($_POST['historial_medico'] ?? ''); ?></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Paciente
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
