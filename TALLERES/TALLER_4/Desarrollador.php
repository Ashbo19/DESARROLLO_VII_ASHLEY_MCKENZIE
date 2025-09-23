<?php
require_once 'Empleado.php';
require_once "Evaluable.php";
 //Desarrollador: Añade propiedades para el lenguaje 
 //de programación principal y nivel de experiencia.
 class Desarrollador extends Empleado implements Evaluable {
    private $lenguajePrincipal;
    private $nivelExperiencia;

    public function __construct($nombre, $idEmpleado, $salarioBase, $lenguajePrincipal, $nivelExperiencia) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->lenguajePrincipal = $lenguajePrincipal;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    public function getLenguajePrincipal() {
        return $this->lenguajePrincipal;
    }

    public function setLenguajePrincipal($lenguajePrincipal) {
        $this->lenguajePrincipal = $lenguajePrincipal;
    }

    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    public function setNivelExperiencia($nivelExperiencia) {
        $this->nivelExperiencia = $nivelExperiencia;
    }

    public function evaluarDesempeno() {
        return "El desarrollador {$this->nombre} con experiencia {$this->nivelExperiencia} en {$this->lenguajePrincipal} tuvo un desempeño Satisfactorio.";
    }
}
?>