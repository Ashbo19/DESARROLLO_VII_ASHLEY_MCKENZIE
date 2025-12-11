<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__ . '/');

require_once BASE_PATH . '../../config.php';
require_once BASE_PATH . '../Database.php';
require_once BASE_PATH . 'usuarioManager.php';
require_once BASE_PATH . 'usuario.php';

$usuarioManager = new UsuarioManager();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $usuarioData = [
                    'id_usuario' => null,
                    'nombre' => $_POST['nombre'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'contraseña' => $_POST['contraseña'] ?? '',
                    'direccion' => $_POST['direccion'] ?? '',
                    'telefono' => $_POST['telefono'] ?? '',
                    'puntos' => 0
                ];
                
                $usuario = new Usuario($usuarioData);
                $result = $usuarioManager->createUsuario($usuario);
                
                if ($result) {
                    $_SESSION['success_message'] = "Usuario creado exitosamente";
                } else {
                    $_SESSION['error_message'] = "Error al crear el usuario";
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error: " . $e->getMessage();
            }
            
            header('Location: index.php');
            exit;
        }
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $usuarioData = [
                        'id_usuario' => $_GET['id'],
                        'nombre' => $_POST['nombre'] ?? '',
                        'email' => $_POST['email'] ?? '',
                        'contraseña' => '',
                        'direccion' => $_POST['direccion'] ?? '',
                        'telefono' => $_POST['telefono'] ?? '',
                        'puntos' => 0
                    ];
                    
                    $usuario = new Usuario($usuarioData);
                    $result = $usuarioManager->updateUsuario($_GET['id'], $usuario);
                    
                    if ($result) {
                        $_SESSION['success_message'] = "Usuario actualizado exitosamente";
                    } else {
                        $_SESSION['error_message'] = "Error al actualizar el usuario";
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Error: " . $e->getMessage();
                }
                
                header('Location: index.php');
                exit;
            }
            
            $usuario = $usuarioManager->getUsuarioById($_GET['id']);
            require BASE_PATH . 'views/edit.php';
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $usuarioManager->deleteUsuario($_GET['id']);
            $_SESSION['success_message'] = "Usuario eliminado exitosamente";
        }
        header('Location: index.php');
        break;

    default:
        $usuarios = $usuarioManager->getAllUsuarios();
        require BASE_PATH . 'views/list.php';
        break;
}