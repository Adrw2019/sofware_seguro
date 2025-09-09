
<?php
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    // Verifica si el email existe en la tabla usuarios
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        // Genera un token seguro
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Guarda el token en la tabla password_resets
        $stmt2 = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt2->bind_param("sss", $email, $token, $expires_at);
        $stmt2->execute();

        // Enlace de recuperación (ajusta la URL según tu entorno)
        $reset_link = "http://localhost/inventario-tecnologico/src/views/reset_password.php?token=$token";

        // Envía el correo
        $subject = "Recupera tu contraseña";
        $message = "Hola,\n\nHaz clic en el siguiente enlace para restablecer tu contraseña:\n$reset_link\n\nEste enlace expirará en 1 hora.";
        $headers = "From: no-reply@tusitio.com\r\n";

        mail($email, $subject, $message, $headers);
    }

    // Siempre muestra mensaje de éxito, aunque el correo no exista (por seguridad)
    header('Location: ../views/recuperar_contrasena.php?success=1');
    exit();
} else {
    header('Location: ../views/recuperar_contrasena.php');
    exit();
}