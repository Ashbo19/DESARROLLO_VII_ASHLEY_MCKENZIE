<?php
require_once "config_pdo.php";
require_once "error_log.php";

// Si se envía el formulario para actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    try {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];

        $sql = "UPDATE usuarios SET nombre=:nombre, email=:email WHERE id=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>✅ Usuario actualizado correctamente con PDO.</p>";
        } else {
            if ($stmt->errorCode() !== '00000') {
                throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
            }
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ ERROR: " . $e->getMessage() . "</p>";
        registrarError("actualizar_usuario_pdo.php - " . $e->getMessage());
    }
}

// Mostrar formulario con datos existentes
if (isset($_GET["id"])) {
    try {
        $id = $_GET["id"];
        $sql = "SELECT * FROM usuarios WHERE id=:id";
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
        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
    </div>
    <input type="submit" value="Actualizar Usuario">
</form>

<?php
        } else {
            echo "<p>No se encontró el usuario.</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>ERROR: " . $e->getMessage() . "</p>";
        registrarError("actualizar_usuario_pdo.php - " . $e->getMessage());
    }
}
unset($stmt);
unset($pdo);
?>