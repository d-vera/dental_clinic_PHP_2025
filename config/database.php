<?php
/**
 * Configuración de la base de datos
 */

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'clinica_medica');

// Crear conexión
function getConnection() {
    try {
        // Usar variables locales para asegurar que los valores se pasen correctamente
        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $dbname = DB_NAME;
        $port = DB_PORT;
        
        $conn = new mysqli($host, $user, $pass, $dbname, $port);
        
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
        
        $conn->set_charset("utf8mb4");
        return $conn;
        
    } catch (Exception $e) {
        die("Error al conectar con la base de datos: " . $e->getMessage());
    }
}

// Función para cerrar conexión
function closeConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}

// Función para escapar datos
function escape($conn, $data) {
    return $conn->real_escape_string(trim($data));
}
?>
