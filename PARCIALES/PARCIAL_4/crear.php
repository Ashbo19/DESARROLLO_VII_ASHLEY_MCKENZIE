<?php
require_once "database.php";
require_once "error_log.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $fecha_registro = $_POST['fecha_registro'];
        
        $sql = "INSERT INTO productos (nombre, categoria, precio, cantidad, fecha_registro) VALUES (:nombre, :categoria, :precio, :cantidad, :fecha_registro)";
        
        //$stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
        $stmt->bindParam(":precio", $precio, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_registro", $fecha_registro, PDO::PARAM_STR);
        
        
        if($stmt->execute()){
            echo "Producto creado con éxito.";
        } else{
            if ($stmt->errorCode() !== '00000') {
                throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
            }
        }
        
        unset($stmt);
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage();
        registrarError("crear.php - " . $e->getMessage());
    }
}

unset($pdo);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Categoria</label><input type="text" name="categoria" required></div>
    <div><label>Precio</label><input type="int" name="precio" required></div>
    <div><label>Cantidad</label><input type="int" name="cantidad" required></div>
    <div><label>Fecha de registro</label><input type="text" name="fechaderegistro" required></div>
    <input type="submit" value="Crear Producto">
</form>