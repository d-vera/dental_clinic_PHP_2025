<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/database.php';

echo "<h2>User Check</h2>";

$conn = getConnection();

// Check if users exist
$query = "SELECT * FROM usuarios";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    echo "<h3>Users in database:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Email</th><th>Role</th><th>Active</th><th>Password Hash</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nombre_completo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['rol']) . "</td>";
        echo "<td>" . ($row['activo'] ? 'Yes' : 'No') . "</td>";
        echo "<td>" . substr($row['password'], 0, 30) . "...</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>❌ No users found in database!</p>";
    echo "<p>You need to run the INSERT statements from database.sql</p>";
}

// Test password verification
echo "<h3>Password Test:</h3>";
$test_password = 'admin123';
$hash_from_sql = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

if (password_verify($test_password, $hash_from_sql)) {
    echo "✅ Password 'admin123' matches the hash from SQL file<br>";
} else {
    echo "❌ Password 'admin123' does NOT match the hash<br>";
}

// Generate new hash
echo "<h3>Generate New Hash:</h3>";
$new_hash = password_hash('admin123', PASSWORD_DEFAULT);
echo "New hash for 'admin123': <code>$new_hash</code><br>";
echo "<br>";
echo "To update admin password, run this SQL:<br>";
echo "<code>UPDATE usuarios SET password = '$new_hash' WHERE username = 'admin';</code>";

closeConnection($conn);
?>
