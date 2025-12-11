<?php
class HistorialIntercambio {
    public $id_historial;
    public $id_intercambio;
    public $fecha;
    public $resultado;

    public function __construct($data) {
        $this->id_historial = $data['id_historial'] ?? null;
        $this->id_intercambio = $data['id_intercambio'] ?? null;
        $this->fecha = $data['fecha'] ?? date('Y-m-d H:i:s');
        $this->resultado = $data['resultado'] ?? 'exitoso';
    }
}