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
        $this->id_intercambio = $data['id_intercambio'] ?? null;
        $this->id_solicitante = $data['id_solicitante'] ?? null;
        $this->id_ofertante = $data['id_ofertante'] ?? null;
        $this->id_libro_solicitado = $data['id_libro_solicitado'] ?? null;
        $this->id_libro_ofrecido = $data['id_libro_ofrecido'] ?? null;
        $this->fecha_intercambio = $data['fecha_intercambio'] ?? date('Y-m-d H:i:s');
        $this->estado = $data['estado'] ?? 'pendiente';
    }

    // Aquí podrían añadirse métodos adicionales relacionados con una tarea individual
}