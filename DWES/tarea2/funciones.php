<?php
require_once 'persona.php';

function addPersona(&$agenda, $nombre, $ntelefono, &$nextId) {
    // Comprobar si ya existe (opcional, para evitar duplicados por nombre)
    foreach ($agenda as $p) {
        if ($p->nombre === $nombre) {
            echo "<p style='color:red;'>Este nombre ya existe, se va a reemplazar.</p>";
            $p->ntelefono = $ntelefono;
            return;
        }
    }

    // Crear y añadir persona
    $persona = new Persona($nextId, $nombre, $ntelefono);
    $agenda[] = $persona;
    $nextId++;
}

function showPersona($agenda) {
    if (empty($agenda)) {
        echo "<p>No hay contactos en la agenda.</p>";
        return;
    }

    echo "<h3>Agenda:</h3><ul>";
    foreach ($agenda as $p) {
        echo "<li>ID: {$p->id} - Nombre: {$p->nombre}, Teléfono: {$p->ntelefono}</li>";
    }
    echo "</ul>";
}
?>
<a href="index.html">Volver</a>

