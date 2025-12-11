<?php
class UsuarioManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllUsuarios() {
        $stmt = $this->db->query("SELECT * FROM usuarios ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarioById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUsuario($usuario) {
        try {
            // Hash the password before storing
            $hashedPassword = password_hash($usuario->contraseña, PASSWORD_DEFAULT);
            
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, contraseña, direccion, telefono, puntos) VALUES (?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $usuario->nombre,
                $usuario->email,
                $hashedPassword,
                $usuario->direccion,
                $usuario->telefono,
                $usuario->puntos
            ]);
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateUsuario($id, $usuario) {
        try {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre = ?, email = ?, direccion = ?, telefono = ? WHERE id_usuario = ?");
            return $stmt->execute([
                $usuario->nombre,
                $usuario->email,
                $usuario->direccion,
                $usuario->telefono,
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUsuario($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id]);
    }

    public function updatePuntos($id, $puntos) {
        $stmt = $this->db->prepare("UPDATE usuarios SET puntos = puntos + ? WHERE id_usuario = ?");
        return $stmt->execute([$puntos, $id]);
    }
}