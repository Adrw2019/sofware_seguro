<?php
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Recuperar Contraseña</title>
  <!-- Ajusta la ruta según dónde esté styles.css respecto a recover.php -->
  <link rel="stylesheet" href="/inventario/inventario-tecnologico/public/css/styles.css?v=107">
</head>
<body class="page-bg">

  <div class="card-outer">
    <h1 class="card-title">Recuperar Contraseña</h1>

    <div class="card-inner">
      <p class="card-subtitle">Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>

      <?php if ($error): ?>
        <div class="alert alert--error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert--success"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <form action="../controllers/recoverController.php" method="POST" class="form-stacked" id="recover-form">
        <label for="email" class="field-label">Email:</label>
        <input type="email" name="email" id="email" class="field-input" placeholder="tucorreo@ejemplo.com" required>
        <button type="submit" class="btn-primary block" id="submit-btn">Enviar enlace de recuperación</button>
      </form>
    </div>

    <div class="card-footer">
      <a href="login.php" class="link-primary">¿Ya la recordaste? Inicia sesión</a>
    </div>
  </div>

  <script>
    (function () {
      const form = document.getElementById('recover-form');
      const btn  = document.getElementById('submit-btn');
      form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.textContent = 'Enviando...';
      });
    })();
  </script>
</body>
</html>