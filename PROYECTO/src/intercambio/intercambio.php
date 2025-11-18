<?php
class intercambio {
    public $id_intercambio;
    public $id_solicitante;
    public $id_ofertante;
    public $id_libro_solicitado;
    public $id_libro_ofrecido;
    public $fecha_intercambio;
    public $estado;

    // Constructor para crear un objeto Task a partir de un array de datos
    //MAPEO
    public function __construct($data) {
        $this->id_intercambio= $data['id intercambio'];
        $this->id_solicitante = $data['id solicitante'];
        $this->id_ofertante= $data['id ofertante'];
        $this->id_libro_solicitado = $data['id libro solicitado'];
        $this->id_libro_ofrecido = $data['id libro ofrecido'];
        $this->fecha_intercambio = $data['fecha intercambio'];
        $this->estado = $data['estado'];
    }

    // Aquí podrían añadirse métodos adicionales relacionados con una tarea individual
}