<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Database Connection</h2>";

// Test 1: Check if constants are defined
echo "<h3>1. Constants Check:</h3>";
require_once __DIR__ . '/config/database.php';

echo "DB_HOST: " . (defined('DB_HOST') ? DB_HOST : 'NOT DEFINED') . "<br>";
echo "DB_PORT: " . (defined('DB_PORT') ? DB_PORT : 'NOT DEFINED') . "<br>";
echo "DB_USER: " . (defined('DB_USER') ? DB_USER : 'NOT DEFINED') . "<br>";
echo "DB_PASS: " . (defined('DB_PASS') ? '***SET***' : 'NOT DEFINED') . "<br>";
echo "DB_NAME: " . (defined('DB_NAME') ? DB_NAME : 'NOT DEFINED') . "<br>";

// Test 2: Try direct connection
echo "<h3>2. Direct Connection Test:</h3>";
try {
    $conn = new mysqli('localhost', 'root', 'Intothenight378#', 'clinica_medica', 3306);
    
    if ($conn->connect_error) {
        echo "❌ Direct connection failed: " . $conn->connect_error . "<br>";
    } else {
        echo "✅ Direct connection successful!<br>";
        echo "MySQL version: " . $conn->server_info . "<br>";
        $conn->close();
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "<br>";
}

// Test 3: Try connection using function
echo "<h3>3. Function Connection Test:</h3>";
try {
    $conn = getConnection();
    echo "✅ Function connection successful!<br>";
    closeConnection($conn);
} catch (Exception $e) {
    echo "❌ Function connection failed: " . $e->getMessage() . "<br>";
}

// Test 4: Check if database exists
echo "<h3>4. Database Check:</h3>";
try {
    $conn = new mysqli('localhost', 'root', 'Intothenight378#', '', 3306);
    $result = $conn->query("SHOW DATABASES LIKE 'clinica_medica'");
    if ($result && $result->num_rows > 0) {
        echo "✅ Database 'clinica_medica' exists<br>";
    } else {
        echo "❌ Database 'clinica_medica' does NOT exist<br>";
        echo "⚠️ You need to import database.sql first<br>";
    }
    $conn->close();
} catch (Exception $e) {
    echo "❌ Error checking database: " . $e->getMessage() . "<br>";
}
?>
