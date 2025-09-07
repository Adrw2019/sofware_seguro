
<?php
session_start();
require_once '../../config/db.php'; // Ajusta la ruta si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validación básica
    if (empty($email) || empty($password)) {
        header('Location: ../views/login.php?error=Campos obligatorios');
        exit();
    }

    // Consulta a la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email']
            ];
            header('Location: ../views/dashboard.php');
            exit();
        } else {
            header('Location: ../views/login.php?error=Contraseña incorrecta');
            exit();
        }
    } else {
        header('Location: ../views/login.php?error=Usuario no encontrado');
        exit();
    }
} else {
    header('Location: ../views/login.php');
    exit();
}