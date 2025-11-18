<?php
declare(strict_types=1);
require_once __DIR__ . '/funciones.php';

function validate_credentials(string $user, string $pass, string $usersFile): ?array {
  $users = read_users_file($usersFile);
  if (!isset($users[$user])) return null;
  $record = $users[$user];
  // Comparación simple por requisitos (archivo plano)
  if ($record['password'] === $pass) {
    return ['user' => $user, 'rol' => $record['rol']];
  }
  return null;
}