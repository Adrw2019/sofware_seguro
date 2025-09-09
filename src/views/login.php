<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php');
    exit();
}
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #e0e7ff 0%, #f4f6f8 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .login-container {
            max-width: 400px;
            margin: 70px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            padding: 38px 32px 28px 32px;
        }
        .login-container h1 {
            text-align: center;
            color: #222;
            margin-bottom: 28px;
            font-size: 2rem;
            font-weight: 700;
        }
        .login-form label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 500;
        }
        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #bbb;
            border-radius: 6px;
            font-size: 1rem;
        }
        .login-form button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.08rem;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(79,70,229,0.08);
            transition: background 0.2s, transform 0.2s;
            margin-bottom: 10px;
        }
        .login-form button:hover {
            background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.03);
        }
        .login-links {
            text-align: center;
            margin-top: 12px;
        }
        .login-links a {
            color: #4f46e5;
            text-decoration: none;
            margin: 0 6px;
            font-size: 0.98rem;
            transition: color 0.2s;
        }
        .login-links a:hover {
            color: #1e40af;
        }
        @media (max-width: 500px) {
            .login-container {
                padding: 18px 6vw;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1><i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form class="login-form" action="../controllers/loginController.php" method="POST">
            <label for="email"><i class="fa-solid fa-envelope"></i> Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password"><i class="fa-solid fa-lock"></i> Contraseña:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit"><i class="fa-solid fa-arrow-right-to-bracket"></i> Ingresar</button>
        </form>
        <div class="login-links">
            <a href="register.php">¿No tienes una cuenta? Regístrate aquí</a><br>
            <a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</body>
</html>