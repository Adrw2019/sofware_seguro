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
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #e0e7ff 0%, #f4f6f8 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .register-container {
            max-width: 480px;
            margin: 70px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            padding: 38px 32px 28px 32px;
            text-align: center;
        }
        .register-container h1 {
            color: #222;
            margin-bottom: 28px;
            font-size: 2rem;
            font-weight: 700;
        }
        .register-form .form-group {
            margin-bottom: 18px;
            text-align: left;
        }
        .register-form label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 500;
        }
        .register-form input[type="text"],
        .register-form input[type="email"],
        .register-form input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #bbb;
            border-radius: 6px;
            font-size: 1rem;
        }
        .register-form button {
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
        .register-form button:hover {
            background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.03);
        }
        .register-links {
            text-align: center;
            margin-top: 12px;
        }
        .register-links a {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.98rem;
            transition: color 0.2s;
        }
        .register-links a:hover {
            color: #1e40af;
        }
        @media (max-width: 500px) {
            .register-container {
                padding: 18px 6vw;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1><i class="fa-solid fa-user-plus"></i> Registro de Usuario</h1>
        <form class="register-form" action="../controllers/registerController.php" method="POST">
            <div class="form-group">
                <label for="nombre"><i class="fa-solid fa-user"></i> Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fa-solid fa-envelope"></i> Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fa-solid fa-lock"></i> Contraseña:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit"><i class="fa-solid fa-user-plus"></i> Registrarse</button>
        </form>
        <div class="register-links">
            <a href="login.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> ¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>