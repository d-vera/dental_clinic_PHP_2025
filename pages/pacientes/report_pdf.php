<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../config/database.php';

requireLogin();

// Configuración para PDF
header('Content-Type: text/html; charset=utf-8');

$conn = getConnection();
$query = "SELECT * FROM pacientes ORDER BY fecha_registro DESC";
$result = $conn->query($query);

$fecha_reporte = date('d/m/Y H:i:s');
$usuario = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pacientes - PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0d6efd;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #0d6efd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #0d6efd;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-primary {
            background-color: #0d6efd;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Imprimir / Guardar PDF</button>

    <div class="header">
        <h1>🏥 CLÍNICA MÉDICA</h1>
        <h2>Reporte de Pacientes Registrados</h2>
        <p>Sistema de Gestión Médica</p>
    </div>

    <div class="info-box">
        <strong>Fecha del Reporte:</strong> <?php echo $fecha_reporte; ?><br>
        <strong>Generado por:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?> (<?php echo htmlspecialchars($usuario['rol']); ?>)<br>
        <strong>Total de Pacientes:</strong> <?php echo $result ? $result->num_rows : 0; ?>
    </div>

    <table>
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
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                    <td><?php echo $row['edad']; ?> años</td>
                    <td>
                        <span class="badge <?php echo $row['genero'] === 'Masculino' ? 'badge-primary' : 'badge-danger'; ?>">
                            <?php echo $row['genero']; ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_sangre'] ?? 'N/A'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['fecha_registro'])); ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        No hay pacientes registrados
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Clínica Médica</strong> - Sistema de Gestión Médica</p>
        <p>Av. Independencia #123, Santo Domingo, República Dominicana</p>
        <p>Tel: +1 (809) 555-0100 | Email: info@clinicamedica.com</p>
        <p>Este documento es confidencial y contiene información médica protegida</p>
    </div>

    <script>
        // Auto-imprimir al cargar (opcional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
<?php
closeConnection($conn);
?>
