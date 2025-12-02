<?php
//Debe mostrar tabla con todos los productos y enlaces para editar y eliminar.
require_once "database.php";
require_once "error_log.php";

// Si se envía el formulario para actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    try {
        $id = $_POST["id"];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $fecha_registro = $_POST['fecha_registro'];

        $sql = "UPDATE productos SET nombre=:nombre, categoria=:categoria, precio=:precio, cantidad=:cantidad, fecha_registro=:fecha_registro, WHERE id=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
        $stmt->bindParam(":precio", $precio, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_registro", $fecha_registro, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>✅ Producto actualizado correctamente con PDO.</p>";
        } else {
            if ($stmt->errorCode() !== '00000') {
                throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
            }
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ ERROR: " . $e->getMessage() . "</p>";
        registrarError("index.php - " . $e->getMessage());
    }
}

// Mostrar formulario con datos existentes
if (isset($_GET["id"])) {
    try {
        $id = $_GET["id"];
        $sql = "SELECT * FROM productos WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->errorCode() !== '00000') {
            throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
        }
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="text" name="categoria" value="<?php echo htmlspecialchars($row['categoria']); ?>" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="int" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>" required>
    </div>
    <input type="submit" value="Actualizar producto">
</form>

<?php
        } else {
            echo "<p>No se encontró el producto.</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>ERROR: " . $e->getMessage() . "</p>";
        registrarError("index.php - " . $e->getMessage());
    }
}
unset($stmt);
unset($pdo);
?>