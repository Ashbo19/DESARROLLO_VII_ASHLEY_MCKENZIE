<?php
require_once __DIR__ . '/../src/sesion.php';
require_once __DIR__ . '/../src/funciones.php';
rol('Profesor');
//require_once __DIR__ . './header.php';

$grades = leer(__DIR__ . '/../data/calificaciones.json');
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Dashboard Profesor</title></head>
<body>
  <main>
    <h2>Bienvenido al dashboard del Profesor</h2>
    <p>A continuación se muestran estudiantes con nombre válido (>= 3 caracteres) y su promedio.</p>
    <table border="1" cellpadding="6" cellspacing="0">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Nombre</th>
          <th>Promedio</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($grades as $usuario => $info): 
          $nombre = $info['nombre'] ?? '';
          $notas = $info['calificaciones'] ?? [];
          if (!nombre($nombre, 3)) continue;
          $prom = promedio($notas);
        ?>
        <tr>
          <td><?= htmlspecialchars($usuario) ?></td>
          <td><?= htmlspecialchars($nombre) ?></td>
          <td><?= number_format($prom, 2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p><a href="notas.php">Ver listado completo de calificaciones</a></p>
  </main>
</body>
</html>