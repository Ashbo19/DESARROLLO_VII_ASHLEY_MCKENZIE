<?php
class libros {
    public $id;
    public $titulo;
    public $autor;
    public $isbn;
    public $anio_publicacion;
    public $cantidad_disponible;
    public $fecha_registro;

    // Constructor para crear un objeto Task a partir de un array de datos
    //MAPEO
    public function __construct($data) {
        $this->id = $data['id'];
        $this->titulo = $data['titulo'];
        $this->autor = $data['autor'];
        $this->isbn = $data['isbn'];
        $this->anio_publicacion = $data['anio de publicacion'];
        $this->cantidad_disponible = $data['cantidad disponible'];
        $this->fecha_registro = $data['fecha de registro'];
    }

    // Aquí podrían añadirse métodos adicionales relacionados con una tarea individual
}