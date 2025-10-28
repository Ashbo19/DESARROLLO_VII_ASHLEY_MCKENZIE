<?php
require_once "config_mysqli.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM usuarios WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p style='color:green;' Usuario eliminado correctamente.</p>";
        } else {
            echo "<p style='color:red;' ERROR: No se pudo eliminar el usuario.</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color:red;' ERROR en la preparación de la sentencia.</p>";
    }
}

mysqli_close($conn);
?>