<?php
require_once 'Empleado.php';
require_once "Evaluable.php";
//Gerente: Añade una propiedad para el departamento 
//que gestiona y un método para asignar bonos.
class Gerente extends Empleado implements Evaluable {
    private $departamento;

    public function __construct($nombre, $id, $salariobase, $departamento) {
        parent::__construct($nombre, $id, $salariobase);
        $this->departamento = $departamento;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function asignarBono($monto) {
        $this->salariobase += $monto;
    }

    public function evaluarDesempeno() {
        return "El gerente {$this->nombre} del depto. {$this->departamento} tuvo un desempeño Excelente.";
    }
}
?>
