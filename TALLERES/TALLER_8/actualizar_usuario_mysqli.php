<?php
require_once "config_mysqli.php";

// Si se envía el formulario para actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $sql = "UPDATE usuarios SET nombre=?, email=? WHERE id=?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p style='color:green;'>✅ Usuario actualizado correctamente.</p>";
        } else {
            echo "<p style='color:red;'>❌ ERROR: No se pudo actualizar el registro.</p>";
        }
        mysqli_stmt_close($stmt);
    }
}

// Mostrar formulario con datos existentes
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM usuarios WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result)) {
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    <input type="submit" value="Actualizar Usuario">
</form>

<?php
    } else {
        echo "<p>No se encontró el usuario.</p>";
    }
}
mysqli_close($conn);
?>