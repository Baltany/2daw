<?php
class Cuenta{
    private $iban;
    private $saldo;
    private $dni_cuenta;

    
    public function __construct($iban=0,$saldo="",$dni_cuenta="",$provincia="",$sexo="",$edad="",$estado_civil="",$aficiones="",$estudios="",$fecha_creacion="") {
        $this->iban=$iban;
        $this->saldo=$saldo;
        $this->dni_cuenta=$dni_cuenta;
        $this->provincia=$provincia;
        $this->sexo=$sexo;
        $this->edad=$edad;
        $this->estado_civil=$estado_civil;
        $this->aficiones=$aficiones;
        $this->estudios=$estudios;
        $this->fecha_creacion=$fecha_creacion;
    }
    
    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    public function __toString(): string {
        return "<br>Cuenta[iban=" . $this->iban
                . ", saldo=" . $this->saldo
                . ", dni_cuenta=" . $this->dni_cuenta
                . "]<br>";
    }
}


?>