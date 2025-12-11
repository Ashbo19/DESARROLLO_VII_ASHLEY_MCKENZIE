<?php
class libros {
    public $id;
    public $titulo;
    public $autor;
    public $isbn;
    public $anio_publicacion;
    public $cantidad_disponible;
    public $categoria;
    public $estado;
    public $descripcion;
    public $id_usuario;
    public $fecha_registro;
    // Constructor para crear un objeto Task a partir de un array de datos
    //MAPEO
    public function __construct($data) {
        $this->id = $data['id_libro'];
        $this->titulo = $data['titulo'];
        $this->autor = $data['autor'] ?? null;
        $this->isbn = $data['isbn'] ?? null;
        $this->anio_publicacion = $data['anio_publicacion'] ?? null;
        $this->cantidad_disponible = $data['cantidad_disponible'] ?? 1;
        $this->categoria = $data['categoria'] ?? 'General';
        $this->estado = $data['estado'] ?? 'nuevo';
        $this->descripcion = $data['descripcion'] ?? '';
        $this->id_usuario = $data['id_usuario'] ?? null;
        $this->fecha_registro = $data['fecha_registro'] ?? null;
    }

    // Aquí podrían añadirse métodos adicionales relacionados con una tarea individual
}