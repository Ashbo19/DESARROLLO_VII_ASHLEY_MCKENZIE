<?php

class Empleado{
    public $nombre;
    public $id;
    public $salariobase;

    public function __construct($nombre, $id, $salariobase) {
        $this->nombre = $nombre;
        $this->id = $id;
        $this->salariobase = $salariobase;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
         $this->nombre = trim($nombre);
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
         $this->id = trim($id);
    }

    public function getSalariobase(){
         return $this->salariobase;
    }

    public function setSalariobase($salariobase){
         $this->salariobase = trim(string: $salariobase);
    }

}