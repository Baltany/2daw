<?php
    require_once 'persona.php';

    class Empleado extends Persona{
        private $salario;

        public function __construct($n ="Antonio",$a="Sanchez", $e="33",$sal=1500){
            parent::__construct($n,$a,$e);
            $this->salario=$sal;
        }
    }
?>