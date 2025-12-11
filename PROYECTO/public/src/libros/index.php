<?php
    session_start();

    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Define the base path for includes
    define('BASE_PATH', __DIR__ . '/');

    // Include the configuration file
    require_once BASE_PATH . '/../config.php';

    // Include necessary files
    require_once BASE_PATH . '../Database.php';
    require_once BASE_PATH . 'librosManager.php';
    require_once BASE_PATH . 'libros.php';

    // Create an instance of TaskManager
    $librosManager = new librosManager();

    // Get the action from the URL, default to 'list' if not set
    $action = $_GET['action'] ?? 'list';

    // Handle different actions
    switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $libroData = [
                    'id_libro' => null, // se autogenera
                    'titulo' => $_POST['titulo'] ?? '',
                    'autor' => $_POST['autor'] ?? '',
                    'isbn' => $_POST['isbn'] ?? null,
                    'anio_publicacion' => !empty($_POST['anio_publicacion']) ? $_POST['anio_publicacion'] : null,
                    'cantidad_disponible' => $_POST['cantidad_disponible'] ?? 1,
                    'categoria' => $_POST['categoria'] ?? 'General',
                    'estado' => $_POST['estado'] ?? 'buen_estado',
                    'descripcion' => $_POST['descripcion'] ?? '',
                    'id_usuario' => $_POST['id_usuario'] ?? 1,
                    'fecha_registro' => $_POST['fecha_registro'] ?? date('Y-m-d'),
                ];
                
                $libro = new libros($libroData);
                $result = $librosManager->createlibros($libro);
                
                if ($result) {
                    $_SESSION['success_message'] = "Libro creado exitosamente";
                } else {
                    $_SESSION['error_message'] = "Error al crear el libro";
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error: " . $e->getMessage();
            }
            
            
            header('Location: list.php');
            exit;
        }
        //require BASE_PATH . 'views/task_form.php';
        break;


    case 'edit':
            exit(" ");

    case 'delete':
        if (isset($_GET['id'])) {
            $librosManager->deletelibros($_GET['id']);
        }
        header('Location: index.php');
        break;
        
    default:
        $libros = $librosManager->getAlllibros();
        require BASE_PATH . 'views/list.php';
        break;
    }