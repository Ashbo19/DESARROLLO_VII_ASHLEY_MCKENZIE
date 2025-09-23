<?php
require_once "Gerente.php";
require_once "Desarrollador.php";
require_once "Empresa.php";

$empresa = new Empresa();

// Crear empleados
$gerente = new Gerente("Ashley Mc kenzie", 1, 2100, "Tecnologia");
$desarrollador = new Desarrollador("Angie Bonilla", 2, 1800, "PHP", "Senior");

// Asignar bono al gerente
$gerente->asignarBono(500);

// Agregar
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

//empleados
echo "<h3>Lista de empleados:</h3>";
$empresa->listarEmpleados();

// nómina
echo "<h3>Nómina total:</h3>";
echo $empresa->calcularNomina() . "<br>";

// Evaluaciones
echo "<h3>Evaluaciones de desempeño:</h3>";
$empresa->realizarEvaluaciones();
?>