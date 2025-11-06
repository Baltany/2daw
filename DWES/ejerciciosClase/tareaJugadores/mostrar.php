<?php
require_once 'funciones.php';

$result = getAllJugadores();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Jugadores</title>
</head>
<body>
    <h1>LISTADO DE JUGADORES</h1>
    
    <?php
    if($result && $result->num_rows > 0){
        echo "<table>";
        echo "<tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Dorsal</th>
                <th>Posición</th>
                <th>Equipo</th>
                <th>Goles</th>
              </tr>";
        
        while($fila = $result->fetch_object()){
            echo "<tr>";
            echo "<td>$fila->nombre</td>";
            echo "<td>$fila->dni</td>";
            echo "<td>$fila->dorsal</td>";
            echo "<td>$fila->posicion</td>";
            echo "<td>$fila->equipo</td>";
            echo "<td>$fila->goles</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }else{
        echo "<p>No hay jugadores dados de alta en la base de datos.</p>";
    }
    ?>
    
    <br>
    <a href="index.php">Volver al menú</a>
</body>
</html>