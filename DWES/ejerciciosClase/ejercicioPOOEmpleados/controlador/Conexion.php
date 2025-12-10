<?php
class Conexion extends PDO {

    private $host = "localhost";
    private $usu = "dwes";
    private $pass = "abc123.";
    private $bd = "pooempleados";

    public function __construct() {
        try {
            parent::__construct("mysql:host={$this->host};dbname={$this->bd};charset=utf8", $this->usu, $this->pass);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}



?>