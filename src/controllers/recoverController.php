<?php
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        header('Location: ../views/recover.php?error=El email es obligatorio');
        exit();
    }

    // Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Limpiar tokens anteriores del email
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        // Generar token único
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Guardar token
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();
        
        // Crear enlace de recuperación
        $reset_link = "http://localhost/inventario/inventario-tecnologico/src/views/reset_password.php?token=" . $token;
        
        // Enviar email
        $subject = "Recuperar Contraseña - Inventario Tecnológico";
        $message = "Hola,\n\nHaz clic en este enlace para restablecer tu contraseña:\n" . $reset_link . "\n\nEste enlace expira en 1 hora.\n\nSi no solicitaste esto, ignora este mensaje.";
        $headers = "From: noreply@inventario.local\r\nReply-To: noreply@inventario.local";
        
        // Simular envío exitoso para pruebas
        $mail_sent = true; // Cambiar por: mail($email, $subject, $message, $headers);
        if ($mail_sent) {
            header('Location: ../views/recover.php?success=Revisa tu email para restablecer la contraseña');
        } else {
            header('Location: ../views/recover.php?error=Error al enviar el email. Intenta más tarde.');
        }
    } else {
        // Por seguridad, siempre mostrar el mismo mensaje
        header('Location: ../views/recover.php?success=Si el email existe, recibirás instrucciones pronto');
    }
    exit();
} else {
    header('Location: ../views/recover.php');
    exit();
}
?>