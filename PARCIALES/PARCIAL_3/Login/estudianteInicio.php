<?php
require_once __DIR__ . '/../src/sesion.php';
require_once __DIR__ . '/../src/funciones.php';
rol('Estudiante');

$grades = leer(__DIR__ . '/../data/calificaciones.json');
$user = $_SESSION['user'];
$info = $grades[$user] ?? ['nombre' => $user, 'calificaciones' => []];
$nombre = $info['nombre'] ?? $user;
$notas = $info['calificaciones'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Dashboard Estudiante</title></head>
<body>
  <main>
    <h2>Bienvenido al dashboard del Estudiante</h2>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
    <?php if ($notas): ?>
      <ul>
        <?php foreach ($notas as $i => $n): ?>
          <li>Nota <?= $i + 1 ?>: <?= htmlspecialchars((string)$n) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No hay calificaciones registradas.</p>
    <?php endif; ?>
  </main>
</body>
</html>