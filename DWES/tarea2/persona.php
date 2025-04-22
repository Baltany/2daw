<?php
class Persona {
    public $id;
    public $nombre;
    public $ntelefono;

    public function __construct($id, $nombre, $ntelefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ntelefono = $ntelefono;
    }
}
?>
