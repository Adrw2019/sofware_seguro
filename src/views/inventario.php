<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$usuario = $_SESSION['usuario'];

// Obtener todos los equipos del usuario
$stmt = $conn->prepare("SELECT * FROM inventarios WHERE usuario_id = ? ORDER BY fecha_ingreso DESC");
$stmt->bind_param("i", $usuario['id']);
$stmt->execute();
$equipos = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Inventario Tecnológico</title>
    <link rel="stylesheet" href="/inventario/inventario-tecnologico/public/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #e0e7ff 0%, #f4f6f8 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }
        .btn {
            background: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.2s;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover {
            background: #6366f1;
            transform: translateY(-2px);
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #f1f5ff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(79,70,229,0.06);
        }
        .stat-card i {
            font-size: 2rem;
            color: #6366f1;
            margin-bottom: 10px;
        }
        .stat-card h3 {
            margin: 0;
            font-size: 1.5rem;
            color: #222;
        }
        .stat-card p {
            margin: 5px 0 0 0;
            color: #6366f1;
            font-weight: 500;
        }
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th {
            background: #4f46e5;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
        }
        th:first-child {
            border-top-left-radius: 12px;
        }
        th:last-child {
            border-top-right-radius: 12px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }
        tr:hover {
            background: #f8f9ff;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .no-items {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        .no-items i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
            display: block;
        }
        .no-items h3 {
            margin: 0 0 10px 0;
            color: #555;
        }
        .no-items p {
            margin: 0;
            font-size: 1.1rem;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
        .btn-small {
            padding: 6px 12px;
            font-size: 0.85rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-edit {
            background: #ffc107;
            color: #212529;
        }
        .btn-edit:hover {
            background: #e0a800;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            .stats {
                grid-template-columns: 1fr;
            }
            table {
                font-size: 0.9rem;
            }
            th, td {
                padding: 8px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fa-solid fa-box-archive"></i> Inventario de Equipos</h1>
            <a href="dashboard.php" class="btn">
                <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>

        <div class="stats">
            <div class="stat-card">
                <i class="fa-solid fa-server"></i>
                <h3><?php echo $equipos->num_rows; ?></h3>
                <p>Total de Equipos</p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-user"></i>
                <h3><?php echo htmlspecialchars($usuario['nombre']); ?></h3>
                <p>Usuario Actual</p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-calendar"></i>
                <h3><?php echo date('d/m/Y'); ?></h3>
                <p>Fecha Actual</p>
            </div>
        </div>

        <?php if ($equipos->num_rows > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Equipo</th>
                            <th>Descripción</th>
                            <th>Número de Serie</th>
                            <th>Fecha de Ingreso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($equipo = $equipos->fetch_assoc()): ?>
                            <tr>
                                <td><strong>#<?php echo $equipo['id']; ?></strong></td>
                                <td>
                                    <i class="fa-solid fa-laptop" style="color: #6366f1; margin-right: 8px;"></i>
                                    <?php echo htmlspecialchars($equipo['nombre_equipo']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($equipo['descripcion'] ?: 'Sin descripción'); ?></td>
                                <td>
                                    <code style="background: #f8f9fa; padding: 2px 6px; border-radius: 4px;">
                                        <?php echo htmlspecialchars($equipo['numero_serie'] ?: 'N/A'); ?>
                                    </code>
                                </td>
                                <td>
                                    <i class="fa-solid fa-calendar-days" style="color: #6c757d; margin-right: 6px;"></i>
                                    <?php echo date('d/m/Y', strtotime($equipo['fecha_ingreso'])); ?>
                                </td>
                                <td>
                                    <span class="badge badge-active">
                                        <i class="fa-solid fa-check-circle"></i> Activo
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <button class="btn-small btn-edit" onclick="editItem(<?php echo $equipo['id']; ?>, '<?php echo htmlspecialchars($equipo['nombre_equipo']); ?>', '<?php echo htmlspecialchars($equipo['descripcion']); ?>', '<?php echo htmlspecialchars($equipo['numero_serie']); ?>', '<?php echo $equipo['fecha_ingreso']; ?>')">
                                            <i class="fa-solid fa-edit"></i> Editar
                                        </button>
                                        <button class="btn-small btn-delete" onclick="deleteItem(<?php echo $equipo['id']; ?>, '<?php echo htmlspecialchars($equipo['nombre_equipo']); ?>')">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-items">
                <i class="fa-solid fa-box-open"></i>
                <h3>No hay equipos registrados</h3>
                <p>Agrega tu primer equipo desde el dashboard para comenzar a gestionar tu inventario.</p>
                <br>
                <a href="dashboard.php" class="btn">
                    <i class="fa-solid fa-plus"></i> Agregar Primer Equipo
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function editItem(id, nombre, descripcion, serie, fecha) {
            if (confirm('¿Deseas editar el equipo "' + nombre + '"?')) {
                // Redirigir al dashboard con parámetros para abrir el modal de edición
                window.location.href = 'dashboard.php?edit=' + id + '&nombre=' + encodeURIComponent(nombre) + '&descripcion=' + encodeURIComponent(descripcion) + '&serie=' + encodeURIComponent(serie) + '&fecha=' + fecha;
            }
        }

        function deleteItem(id, nombre) {
            if (confirm('¿Estás seguro de que deseas eliminar el equipo "' + nombre + '"?\n\nEsta acción no se puede deshacer.')) {
                // Crear un formulario temporal para enviar la eliminación
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'eliminar_item.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id_item';
                input.value = id;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>