<?php
class Usuario {
    public $id_usuario;
    public $nombre;
    public $email;
    public $contraseña;
    public $direccion;
    public $telefono;
    public $puntos;
    public $created_at;
    public $updated_at;

    public function __construct($data) {
        $this->id_usuario = $data['id_usuario'] ?? null;
        $this->nombre = $data['nombre'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->contraseña = $data['contraseña'] ?? '';
        $this->direccion = $data['direccion'] ?? '';
        $this->telefono = $data['telefono'] ?? '';
        $this->puntos = $data['puntos'] ?? 0;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }
}
