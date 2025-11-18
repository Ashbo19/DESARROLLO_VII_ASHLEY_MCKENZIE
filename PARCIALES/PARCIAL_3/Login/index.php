<?php
require_once __DIR__ . '/../src/sesion.php';
//require_once __DIR__ . '/src/funciones.php';
//require_once __DIR__ . '/src/validar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Inicio</title></head>
<body>
  <main>
    <h2>Bienvenidos</h2>
    <?php if (!empty($_SESSION['auth'])): ?>
      <p>Bienvenido</p>
      <?php
        if ($_SESSION['rol'] === 'Profesor') {
          header('Refresh: 1; URL=profesorInicio.php');
        } elseif ($_SESSION['rol'] === 'Estudiante') {
          header('Refresh: 1; URL=estudianteInicio.php');
        }
      ?>
    <?php else: ?>
      <p>inicia sesión para continuar.</p>
      <a href="login.php">Ir al login</a>
    <?php endif; ?>
  </main>
</body>
</html>