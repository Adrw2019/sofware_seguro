<?php
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_item = $_POST['id_item'] ?? '';
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
        $stmt = $conn->prepare("DELETE FROM inventarios WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $id_item, $usuario_id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header('Location: dashboard.php?success=Item eliminado correctamente');
            } else {
                header('Location: dashboard.php?error=Item no encontrado o no tienes permisos');
            }
        } else {
            header('Location: dashboard.php?error=Error al eliminar item');
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