<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../config/database.php';

// Solo administradores pueden generar reportes de médicos
requireAdmin();

header('Content-Type: text/html; charset=utf-8');

$conn = getConnection();
$query = "SELECT * FROM medicos ORDER BY fecha_registro DESC";
$result = $conn->query($query);

$fecha_reporte = date('d/m/Y H:i:s');
$usuario = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Médicos - PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #198754;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #198754;
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
            border-left: 4px solid #198754;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #198754;
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
        .badge-info {
            background-color: #0dcaf0;
            color: black;
        }
        .badge-success {
            background-color: #198754;
            color: white;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #198754;
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
        <h2>Reporte de Médicos Registrados</h2>
        <p>Sistema de Gestión Médica</p>
    </div>

    <div class="info-box">
        <strong>Fecha del Reporte:</strong> <?php echo $fecha_reporte; ?><br>
        <strong>Generado por:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?> (<?php echo htmlspecialchars($usuario['rol']); ?>)<br>
        <strong>Total de Médicos:</strong> <?php echo $result ? $result->num_rows : 0; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Especialidad</th>
                <th>Cédula Prof.</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Horario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                    <td>
                        <span class="badge badge-info">
                            <?php echo htmlspecialchars($row['especialidad']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['cedula_profesional']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['horario_atencion'] ?? 'N/A'); ?></td>
                    <td>
                        <?php if ($row['activo']): ?>
                        <span class="badge badge-success">Activo</span>
                        <?php else: ?>
                        <span class="badge badge-secondary">Inactivo</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        No hay médicos registrados
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
</body>
</html>
<?php
closeConnection($conn);
?>
