<?php
declare(strict_types=1);

function start_session(): void {
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
}

function validar(): void {
  start_session();
  if (empty($_SESSION['auth']) || empty($_SESSION['user']) || empty($_SESSION['rol'])) {
    header('Location: login.php?error=auth');
    exit;
  }
}

function rol(string $role): void {
  validar();
  if ($_SESSION['rol'] !== $role) {
    header('Location: acceso_denegado.php');
    exit;
  }
}

function login_user(string $user, string $role): void {
  start_session();
  session_regenerate_id(true);
  $_SESSION['auth'] = true;
  $_SESSION['user'] = $user;
  $_SESSION['rol'] = $role;
}

function logout_user(): void {
  start_session();
  $_SESSION = [];
  session_destroy();
}