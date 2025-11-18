<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
  <main>
    <h2>Inicio de sesión</h2>
    <?php if ($error === 'invalid'): ?>
      <p style="color:red;">Invalido. Verifica usuario y contraseña.</p>
    <?php elseif ($error === 'auth'): ?>
      <p style="color:red;">Debes iniciar sesión para acceder.</p>
    <?php endif; ?>
    <form action="autenticar.php" method="POST">
      <label for="user">Nombre de usuario:</label>
      <input type="text" id="user" name="user" required />
      <br/><br/>
      <label for="pass">Contraseña:</label>
      <input type="password" id="pass" name="pass" required />
      <br/><br/>
      <button type="submit">Entrar</button>
    </form>
  </main>
</body>
</html>