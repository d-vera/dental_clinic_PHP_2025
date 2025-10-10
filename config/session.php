<?php
/**
 * Configuración de sesiones y autenticación
 */

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Verificar si el usuario es administrador
function isAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador';
}

// Requerir login
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /clinic/login.php");
        exit();
    }
}

// Requerir rol de administrador
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: /clinic/index.php");
        exit();
    }
}

// Obtener información del usuario actual
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'nombre' => $_SESSION['nombre_completo'],
            'email' => $_SESSION['email'],
            'rol' => $_SESSION['rol']
        ];
    }
    return null;
}

// Cerrar sesión
function logout() {
    session_unset();
    session_destroy();
    header("Location: /clinic/login.php");
    exit();
}
?>
