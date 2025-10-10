<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Setup</h2>";

// Read database.sql file
$sqlFile = __DIR__ . '/database.sql';
if (!file_exists($sqlFile)) {
    die("Error: database.sql file not found!");
}

$sql = file_get_contents($sqlFile);

// Connect to MySQL
$conn = new mysqli('localhost', 'root', 'Intothenight378#', '', 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<p>✅ Connected to MySQL successfully</p>";

// Split SQL into individual statements
$statements = array_filter(
    array_map('trim', explode(';', $sql)),
    function($stmt) {
        return !empty($stmt) && !preg_match('/^--/', $stmt);
    }
);

$success = 0;
$errors = 0;

foreach ($statements as $statement) {
    if (empty(trim($statement))) continue;
    
    if ($conn->query($statement)) {
        $success++;
        // Show only important operations
        if (stripos($statement, 'CREATE DATABASE') !== false) {
            echo "<p>✅ Database created</p>";
        } elseif (stripos($statement, 'CREATE TABLE') !== false) {
            preg_match('/CREATE TABLE.*?`?(\w+)`?/i', $statement, $matches);
            if (isset($matches[1])) {
                echo "<p>✅ Table '{$matches[1]}' created</p>";
            }
        } elseif (stripos($statement, 'INSERT INTO') !== false) {
            preg_match('/INSERT INTO\s+`?(\w+)`?/i', $statement, $matches);
            if (isset($matches[1])) {
                echo "<p>✅ Data inserted into '{$matches[1]}'</p>";
            }
        }
    } else {
        // Only show errors that are not "already exists"
        if (stripos($conn->error, 'already exists') === false && 
            stripos($conn->error, 'Duplicate entry') === false) {
            echo "<p>❌ Error: " . $conn->error . "</p>";
            $errors++;
        }
    }
}

$conn->close();

echo "<hr>";
echo "<h3>Summary</h3>";
echo "<p>✅ Successful operations: $success</p>";
if ($errors > 0) {
    echo "<p>❌ Errors: $errors</p>";
}

echo "<hr>";
echo "<h3>Test Login Credentials</h3>";
echo "<ul>";
echo "<li><strong>Admin:</strong> username = <code>admin</code>, password = <code>admin123</code></li>";
echo "<li><strong>User:</strong> username = <code>usuario</code>, password = <code>admin123</code></li>";
echo "</ul>";

echo "<hr>";
echo "<p><a href='login.php' class='btn btn-primary'>Go to Login Page</a></p>";

// Verify users were created
$conn = new mysqli('localhost', 'root', 'Intothenight378#', 'clinica_medica', 3306);
if (!$conn->connect_error) {
    $result = $conn->query("SELECT username, nombre_completo, rol FROM usuarios");
    if ($result && $result->num_rows > 0) {
        echo "<h3>Users in Database:</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Username</th><th>Name</th><th>Role</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nombre_completo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rol']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    $conn->close();
}
?>
<style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    table { border-collapse: collapse; margin-top: 10px; }
    th { background: #f0f0f0; }
</style>
