<?php
require_once "config_pdo.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM usuarios WHERE id = :id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p style='color:green;' Usuario eliminado correctamente con PDO.</p>";
        } else {
            echo "<p style='color:red;' ERROR: No se pudo eliminar el usuario.</p>";
        }
    }
}

unset($stmt);
unset($pdo);
?>