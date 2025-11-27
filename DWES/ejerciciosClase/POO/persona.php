<?php

class Persona {
    public $nombre;
    public $apellidos;
    public $edad;
    public static $numpersona=0;


    public function __construct($n="Antonio",$a="Sanchez",$e="33") {
        $this->nombre = $n;
        $this->apellidos = $a;
        $this->edad = $e;
        self::$numpersona++;
    }

    public function __destruct(){
        self::$numpersona--;
    }

    public static function numPersona(){
        return self::$numpersona;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }

    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }

    public function __toString(): string {
        return "<br> Mi nombre es ".$this->nombre." ".$this->apellidos." y tengo ".$this->edad." años ";
    }
    
    public function __clone(): void {
        $this->edad=0;
        self::$numpersona++;
    }

    public function __call(string $name, array $arguments) {
        if($name == "modificar"){
            if(count($arguments)==1) {
                $this->nombre=$arguments[0];
            }
        }

        if($name == "modificar"){
            if(count($arguments)==2) {
                $this->nombre=$arguments[0];
                $this->apellidos=$arguments[1];
            }
        }

        if($name == "modificar"){
            if(count($arguments)==3) {
                $this->nombre=$arguments[0];
                $this->apellidos=$arguments[1];
                $this->edad=$arguments[2];;
            }
        }

        if($name=="calcular"){
            
        }
    }
}