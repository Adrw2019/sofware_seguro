<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$usuario = $_SESSION['usuario'];

// Mostrar mensajes
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

// Contar equipos registrados
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM inventarios WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario['id']);
$stmt->execute();
$result = $stmt->get_result();
$equipos_count = $result->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventario Tecnológico</title>
    <link rel="stylesheet" href="/inventario/inventario-tecnologico/public/css/styles.css">
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #e0e7ff 0%, #f4f6f8 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 48px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            padding: 48px 40px 32px 40px;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 18px;
            margin-bottom: 36px;
        }
        .dashboard-header h1 {
            margin: 0;
            font-size: 2.2rem;
            color: #222;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .dashboard-header nav a {
            color: #4f46e5;
            text-decoration: none;
            margin-left: 22px;
            font-weight: 600;
            font-size: 1.08rem;
            transition: color 0.2s;
        }
        .dashboard-header nav a:hover {
            color: #1e40af;
        }
        .dashboard-section {
            margin-bottom: 32px;
        }
        .dashboard-section h2 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 18px;
            font-weight: 600;
        }
        .summary-card {
            background: #f1f5ff;
            border-radius: 12px;
            padding: 24px 28px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 2px 8px rgba(79,70,229,0.06);
            margin-bottom: 10px;
        }
        .summary-card i {
            font-size: 2.2rem;
            color: #6366f1;
            background: #e0e7ff;
            border-radius: 50%;
            padding: 16px;
        }
        .summary-card .summary-info {
            flex: 1;
        }
        .summary-card .summary-info span {
            display: block;
            color: #6366f1;
            font-size: 1.1rem;
            font-weight: 500;
        }
        .summary-card .summary-info strong {
            font-size: 1.5rem;
            color: #222;
        }
        .dashboard-actions {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
        }
        .dashboard-actions button {
            background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 1.08rem;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(79,70,229,0.08);
            transition: background 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .dashboard-actions button:hover {
            background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.03);
        }
        footer {
            text-align: center;
            color: #888;
            margin-top: 40px;
            font-size: 0.98rem;
        }
        /* Estilos para los modales */
        .modal {
          display: none;
          position: fixed;
          z-index: 1000;
          left: 0; top: 0;
          width: 100%; height: 100%;
          overflow: auto;
          background: rgba(44, 62, 80, 0.25);
        }
        .modal-content {
          background: #fff;
          margin: 60px auto;
          padding: 30px 30px 20px 30px;
          border-radius: 12px;
          max-width: 400px;
          box-shadow: 0 8px 32px rgba(0,0,0,0.18);
          position: relative;
          animation: modalShow 0.2s;
        }
        @keyframes modalShow {
          from {transform: translateY(-40px); opacity: 0;}
          to {transform: translateY(0); opacity: 1;}
        }
        .close {
          color: #888;
          position: absolute;
          right: 18px;
          top: 12px;
          font-size: 1.7rem;
          font-weight: bold;
          cursor: pointer;
        }
        .modal-content h2 {
          margin-top: 0;
          color: #4f46e5;
        }
        .modal-content label {
          display: block;
          margin-top: 12px;
          color: #333;
          font-weight: 500;
        }
        .modal-content input[type="text"],
        .modal-content input[type="number"],
        .modal-content input[type="date"] {
          width: 100%;
          padding: 8px 10px;
          margin-top: 4px;
          border: 1px solid #bbb;
          border-radius: 5px;
          font-size: 15px;
        }
        .modal-content button[type="submit"] {
          margin-top: 18px;
          width: 100%;
          padding: 10px;
          background: #4f46e5;
          color: #fff;
          border: none;
          border-radius: 6px;
          font-size: 16px;
          cursor: pointer;
          transition: background 0.2s;
        }
        .modal-content button[type="submit"]:hover {
          background: #6366f1;
        }
        .btn-delete {
          background: #dc3545 !important;
        }
        .btn-delete:hover {
          background: #c82333 !important;
        }
        .warning-text {
          color: #721c24;
          margin-bottom: 20px;
          padding: 10px;
          background: #f8d7da;
          border-radius: 6px;
          border: 1px solid #f5c6cb;
        }
        @media (max-width: 900px) {
            .dashboard-container {
                padding: 20px 3vw;
            }
        }
        @media (max-width: 600px) {
            .dashboard-header {
                flex-direction: column;
                gap: 16px;
            }
            .dashboard-container {
                padding: 10px 2vw;
            }
            .dashboard-actions {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1><i class="fa-solid fa-laptop-code"></i> ¡Hola, <?php echo htmlspecialchars($usuario['nombre']); ?>!</h1>
            <nav>
                <a href="inventario.php"><i class="fa-solid fa-box-archive"></i> Inventario</a>
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
            </nav>
        </div>

        <?php if ($success): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                <i class="fa-solid fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <i class="fa-solid fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-section">
            <h2><i class="fa-solid fa-chart-pie"></i> Resumen del Inventario</h2>
            <div class="summary-card">
                <i class="fa-solid fa-server"></i>
                <div class="summary-info">
                    <span>Equipos registrados</span>
                    <strong><?php echo $equipos_count; ?></strong>
                </div>
            </div>
            <div class="summary-card">
                <i class="fa-solid fa-user"></i>
                <div class="summary-info">
                    <span>Usuario actual</span>
                    <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong>
                </div>
            </div>
        </div>
        <div class="dashboard-section">
            <h2><i class="fa-solid fa-bolt"></i> Acciones Rápidas</h2>
            <div class="dashboard-actions">
                <button id="add-item"><i class="fa-solid fa-plus"></i> Agregar Item</button>
                <button id="update-item"><i class="fa-solid fa-pen-to-square"></i> Actualizar Item</button>
                <button id="delete-item"><i class="fa-solid fa-trash"></i> Eliminar Item</button>
            </div>
        </div>
        <footer>
            &copy; 2025 Inventario Tecnológico. Todos los derechos reservados.
        </footer>
    </div>

    <!-- Modal Agregar Item -->
    <div id="modalAdd" class="modal">
      <div class="modal-content">
        <span class="close" id="closeAdd">&times;</span>
        <h2>Agregar Item</h2>
        <form action="agregar_item.php" method="POST">
          <label for="nombre_equipo">Nombre del equipo:</label>
          <input type="text" name="nombre_equipo" id="nombre_equipo" required>
          <label for="descripcion">Descripción:</label>
          <input type="text" name="descripcion" id="descripcion">
          <label for="numero_serie">Número de serie:</label>
          <input type="text" name="numero_serie" id="numero_serie">
          <label for="fecha_ingreso">Fecha de ingreso:</label>
          <input type="date" name="fecha_ingreso" id="fecha_ingreso" required>
          <button type="submit">Guardar</button>
        </form>
      </div>
    </div>
    
    <!-- Modal Actualizar Item -->
    <div id="modalUpdate" class="modal">
      <div class="modal-content">
        <span class="close" id="closeUpdate">&times;</span>
        <h2>Actualizar Item</h2>
        <form action="actualizar_item.php" method="POST">
          <label for="id_item">ID del Item:</label>
          <input type="number" name="id_item" id="id_item" required>
          <label for="nombre_equipo_upd">Nombre del equipo:</label>
          <input type="text" name="nombre_equipo" id="nombre_equipo_upd">
          <label for="descripcion_upd">Descripción:</label>
          <input type="text" name="descripcion" id="descripcion_upd">
          <label for="numero_serie_upd">Número de serie:</label>
          <input type="text" name="numero_serie" id="numero_serie_upd">
          <label for="fecha_ingreso_upd">Fecha de ingreso:</label>
          <input type="date" name="fecha_ingreso" id="fecha_ingreso_upd">
          <button type="submit">Actualizar</button>
        </form>
      </div>
    </div>

    <!-- Modal Eliminar Item -->
    <div id="modalDelete" class="modal">
      <div class="modal-content">
        <span class="close" id="closeDelete">&times;</span>
        <h2>Eliminar Item</h2>
        <div class="warning-text">
          <i class="fa-solid fa-exclamation-triangle"></i> 
          ¿Estás seguro de que deseas eliminar este item? Esta acción no se puede deshacer.
        </div>
        <form action="eliminar_item.php" method="POST">
          <label for="id_item_del">ID del Item a eliminar:</label>
          <input type="number" name="id_item" id="id_item_del" required>
          <button type="submit" class="btn-delete">Eliminar</button>
        </form>
      </div>
    </div>

    <script src="/inventario/inventario-tecnologico/public/js/scripts.js"></script>
    <!-- Script para abrir/cerrar modales -->
    <script>
    document.getElementById('add-item').onclick = function() {
      document.getElementById('modalAdd').style.display = 'block';
    };
    document.getElementById('update-item').onclick = function() {
      document.getElementById('modalUpdate').style.display = 'block';
    };
    document.getElementById('delete-item').onclick = function() {
      document.getElementById('modalDelete').style.display = 'block';
    };
    document.getElementById('closeAdd').onclick = function() {
      document.getElementById('modalAdd').style.display = 'none';
    };
    document.getElementById('closeUpdate').onclick = function() {
      document.getElementById('modalUpdate').style.display = 'none';
    };
    document.getElementById('closeDelete').onclick = function() {
      document.getElementById('modalDelete').style.display = 'none';
    };
    window.onclick = function(event) {
      if (event.target == document.getElementById('modalAdd')) {
        document.getElementById('modalAdd').style.display = 'none';
      }
      if (event.target == document.getElementById('modalUpdate')) {
        document.getElementById('modalUpdate').style.display = 'none';
      }
      if (event.target == document.getElementById('modalDelete')) {
        document.getElementById('modalDelete').style.display = 'none';
      }
    };
    </script>
</body>
</html>