<?php


function validar_text(string $v): string {
  // return filter_var(trim($nombre), FILTER_SANITIZE_STRING);
  return trim(filter_var($v, FILTER_SANITIZE_SPECIAL_CHARS));
}

function read_users_file(string $path): array {
  if (!is_file($path)) return [];
  // return filter_var(trim($nombre), FILTER_SANITIZE_STRING);
  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $users = [];
  foreach ($lines as $line) {
    $parts = explode(';', $line);
    if (count($parts) === 3) {
      [$u, $p, $r] = $parts;
      $users[$u] = ['password' => $p, 'rol' => $r];
    }
  }
  return $users;
}

function leer(string $path): array {
  if (!is_file($path)) return [];
  $json = file_get_contents($path);
  $data = json_decode($json, true);
  return is_array($data) ? $data : [];
}

function promedio(array $notas): float {
  if (!$notas) return 0.0;
  return array_sum($notas) / count($notas);
}

function nombre(string $name, int $min = 3): bool {
  return mb_strlen(trim($name)) >= $min;
}