<?php
session_start();
require_once '../../config/db.php'; // Ajusta la ruta si es necesario
?>
<link rel="stylesheet" href="/inventario/inventario-tecnologico/public/css/styles.css">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validación básica
    if (empty($nombre) || empty($email) || empty($password)) {
        header('Location: ../views/register.php?error=Todos los campos son obligatorios');
        exit();
    }

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header('Location: ../views/register.php?error=El email ya está registrado');
        exit();
    }
    $stmt->close();

    // Hashear la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $passwordHash);

    if ($stmt->execute()) {
        $_SESSION['usuario'] = [
            'id' => $stmt->insert_id,
            'nombre' => $nombre,
            'email' => $email
        ];
        header('Location: ../views/dashboard.php');
        exit();
    } else {
        header('Location: ../views/register.php?error=Error al registrar usuario');
        exit();
    }
} else {
    header('Location: ../views/register.php');
    exit();
}