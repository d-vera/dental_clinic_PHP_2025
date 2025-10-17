<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session.php';

// Si ya está logueado, redirigir al inicio
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validación backend
    if (empty($username) || empty($password)) {
        $error = 'Por favor, complete todos los campos';
    } else {
        $conn = getConnection();
        $username = escape($conn, $username);
        
        $query = "SELECT * FROM usuarios WHERE username = '$username' AND activo = 1";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verificar contraseña
            // Para este ejemplo, usamos password_verify con hash bcrypt
            // La contraseña de prueba es: admin123
            if (password_verify($password, $user['password'])) {
                // Login exitoso
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nombre_completo'] = $user['nombre_completo'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['rol'] = $user['rol'];
                
                header("Location: index.php");
                exit();
            } else {
                $error = 'Usuario o contraseña incorrectos';
            }
        } else {
            $error = 'Usuario o contraseña incorrectos';
        }
        
        closeConnection($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Clínica Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card login-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="bi bi-hospital text-primary" style="font-size: 4rem;"></i>
                                <h2 class="mt-3">Clínica Médica</h2>
                                <p class="text-muted">Iniciar Sesión</p>
                            </div>

                            <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>

                            <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>

                            <form method="POST" action="" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Usuario</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="username" name="username" 
                                               required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                                        <div class="invalid-feedback">
                                            Por favor, ingrese su usuario
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'toggleIcon')">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                        <div class="invalid-feedback">
                                            Por favor, ingrese su contraseña
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                </button>

                                <div class="text-center">
                                    <small class="text-muted">
                                        <a href="index.php" class="text-decoration-none">Volver al inicio</a>
                                    </small>
                                </div>
                            </form>

                            <hr class="my-4">

                            <div class="alert alert-info mb-0">
                                <small>
                                    <strong>Usuarios de prueba:</strong><br>
                                    Admin: <code>admin</code> / <code>admin123</code><br>
                                    Usuario: <code>usuario</code> / <code>admin123</code>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
