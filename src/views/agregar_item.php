<?php
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_equipo = trim($_POST['nombre_equipo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $numero_serie = trim($_POST['numero_serie'] ?? '');
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
    $usuario_id = $_SESSION['usuario']['id'] ?? null;
    
    if (empty($nombre_equipo)) {
        header('Location: dashboard.php?error=El nombre del equipo es obligatorio');
        exit();
    }
    
    if (!$usuario_id) {
        header('Location: dashboard.php?error=Usuario no válido');
        exit();
    }
    
    try {
        $stmt = $conn->prepare("INSERT INTO inventarios (nombre_equipo, descripcion, numero_serie, fecha_ingreso, usuario_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nombre_equipo, $descripcion, $numero_serie, $fecha_ingreso, $usuario_id);
        
        if ($stmt->execute()) {
            header('Location: dashboard.php?success=Item agregado correctamente');
        } else {
            header('Location: dashboard.php?error=Error al agregar item');
        }
    } catch (Exception $e) {
        header('Location: dashboard.php?error=Error: ' . $e->getMessage());
    }
    exit();
} else {
    header('Location: dashboard.php');
    exit();
}
?>