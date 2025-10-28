<?php
require_once "config_mysqli.php";
require_once "error_log.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        
        $sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $nombre, $email);
            
            if(mysqli_stmt_execute($stmt)){
                echo "Usuario creado con éxito.";
            } else{
                throw new Exception("Error en la consulta: " . mysqli_error($conn));
            }
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage();
        registrarError("crear_usuario_mysqli.php - " . $e->getMessage());
    }
}

mysqli_close($conn);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Crear Usuario">
</form>