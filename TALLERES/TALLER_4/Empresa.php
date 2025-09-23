<?php
// Empresa.php
class Empresa {
    private $empleados = [];

    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            echo "ID: {$empleado->getId()} | Nombre: {$empleado->getNombre()} | Salario: {$empleado->getSalariobase()}<br>";
        }
    }

    public function calcularNomina() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            $total += $empleado->getSalariobase();
        }
        return $total;
    }

    public function realizarEvaluaciones() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempeno() . "<br>";
            }
        }
    }
}
?>