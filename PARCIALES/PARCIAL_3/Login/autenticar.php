<?php
//require_once __DIR__ . './src/sesion.php';
require_once __DIR__ . '/../src/funciones.php';
require_once __DIR__ . '/../src/validar.php';
require_once __DIR__ . '/../src/sesion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: login.php');
  exit;
}

$user = validar_text($_POST['user'] ?? '');
$pass = validar_text($_POST['pass'] ?? '');

if ($user === '' || $pass === '') {
  header('Location: login.php?error=invalid');
  exit;
}

$creds = validate_credentials($user, $pass, __DIR__ . '/../data/usuarios.txt');

if ($creds) {
  login_user($creds['user'], $creds['rol']);
  if ($creds['rol'] === 'Profesor') {
    header('Location: profesorInicio.php');
  } else {
    header('Location: estudianteInicio.php');
  }
  exit;
}

header('Location: login.php?error=invalid');
exit;