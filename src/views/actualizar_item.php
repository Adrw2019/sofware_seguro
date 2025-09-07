<?php
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_item = $_POST['id_item'] ?? '';
    $nombre_equipo = trim($_POST['nombre_equipo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $numero_serie = trim($_POST['numero_serie'] ?? '');
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
    $usuario_id = $_SESSION['usuario']['id'] ?? null;
    
    if (empty($id_item)) {
        header('Location: dashboard.php?error=ID del item es obligatorio');
        exit();
    }
    
    if (!$usuario_id) {
        header('Location: dashboard.php?error=Usuario no válido');
        exit();
    }
    
    try {
        // Verificar que el item existe y pertenece al usuario
        $stmt = $conn->prepare("SELECT id FROM inventarios WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $id_item, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            header('Location: dashboard.php?error=Item no encontrado o no tienes permisos');
            exit();
        }
        
        // Construir la consulta de actualización dinámicamente
        $updates = [];
        $params = [];
        $types = "";
        
        if (!empty($nombre_equipo)) {
            $updates[] = "nombre_equipo = ?";
            $params[] = $nombre_equipo;
            $types .= "s";
        }
        
        if (!empty($descripcion)) {
            $updates[] = "descripcion = ?";
            $params[] = $descripcion;
            $types .= "s";
        }
        
        if (!empty($numero_serie)) {
            $updates[] = "numero_serie = ?";
            $params[] = $numero_serie;
            $types .= "s";
        }
        
        if (!empty($fecha_ingreso)) {
            $updates[] = "fecha_ingreso = ?";
            $params[] = $fecha_ingreso;
            $types .= "s";
        }
        
        if (empty($updates)) {
            header('Location: dashboard.php?error=No hay campos para actualizar');
            exit();
        }
        
        // Agregar el ID al final
        $params[] = $id_item;
        $params[] = $usuario_id;
        $types .= "ii";
        
        $sql = "UPDATE inventarios SET " . implode(", ", $updates) . " WHERE id = ? AND usuario_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header('Location: dashboard.php?success=Item actualizado correctamente');
            } else {
                header('Location: dashboard.php?error=No se realizaron cambios');
            }
        } else {
            header('Location: dashboard.php?error=Error al actualizar item');
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