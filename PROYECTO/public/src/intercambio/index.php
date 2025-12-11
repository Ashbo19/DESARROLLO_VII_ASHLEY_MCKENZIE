<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__ . '/');

require_once BASE_PATH . '../../config.php';
require_once BASE_PATH . '../Database.php';
require_once BASE_PATH . 'IntercambioManager.php';
require_once BASE_PATH . 'Intercambio.php';

$intercambioManager = new IntercambioManager();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $intercambioData = [
                    'id_intercambio' => null,
                    'id_solicitante' => $_POST['id_solicitante'] ?? null,
                    'id_ofertante' => $_POST['id_ofertante'] ?? null,
                    'id_libro_solicitado' => $_POST['id_libro_solicitado'] ?? null,
                    'id_libro_ofrecido' => $_POST['id_libro_ofrecido'] ?? null,
                    'fecha_intercambio' => date('Y-m-d H:i:s'),
                    'estado' => 'pendiente'
                ];
                
                $intercambio = new Intercambio($intercambioData);
                $result = $intercambioManager->createIntercambio($intercambio);
                
                if ($result) {
                    $_SESSION['success_message'] = "Intercambio creado exitosamente";
                } else {
                    $_SESSION['error_message'] = "Error al crear el intercambio";
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error: " . $e->getMessage();
            }
            
            header('Location: index.php');
            exit;
        }
        break;

    case 'cambiar_estado':
        if (isset($_GET['id']) && isset($_GET['estado'])) {
            $intercambioManager->updateEstado($_GET['id'], $_GET['estado']);
            $_SESSION['success_message'] = "Estado actualizado exitosamente";
        }
        header('Location: index.php');
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $intercambioManager->deleteIntercambio($_GET['id']);
            $_SESSION['success_message'] = "Intercambio eliminado exitosamente";
        }
        header('Location: index.php');
        break;

    default:
        $intercambios = $intercambioManager->getAllIntercambio();
        require BASE_PATH . 'views/list.php';
        break;
}