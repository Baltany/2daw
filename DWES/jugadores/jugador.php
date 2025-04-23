<?php
class Jugador{
    public $id;
    public $nombre;
    public $dni;
    public $dorsal;
    public $posicion;
    public $equipo;
    public $goles;

    public function __construct($id,$nombre,$dni,$dorsal,$posicion,$equipo,$goles){
        $this -> id = $id;
        $this -> nombre = $nombre;
        $this -> dni = $dni;
        $this -> dorsal = $dorsal;
        $this -> posicion = $posicion;
        $this -> equipo = $equipo;
        $this -> goles = $goles;
    }
}
?>