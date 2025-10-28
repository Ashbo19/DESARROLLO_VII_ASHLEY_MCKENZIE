<?php
require_once "config_pdo.php";
require_once "error_log.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        
        $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        if($stmt->execute()){
            echo "Usuario creado con éxito.";
        } else{
            if ($stmt->errorCode() !== '00000') {
                throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
            }
        }
        
        unset($stmt);
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage();
        registrarError("crear_usuario_pdo.php - " . $e->getMessage());
    }
}

unset($pdo);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Crear Usuario">
</form>