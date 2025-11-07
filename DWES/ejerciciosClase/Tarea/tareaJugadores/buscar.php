<?php
require_once 'funciones.php';

$result = null;
$busqueda_realizada = false;

if(isset($_POST['buscar'])){
    $campo = $_POST['campo'];
    $valor = trim($_POST['valor']);
    
    if(!empty($valor)){
        $result = buscarJugador($campo, $valor);
        $busqueda_realizada = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Jugador</title>
</head>
<body>
    <h1>BUSCAR JUGADOR</h1>
    
    <form action="" method="post">
        Buscar por: 
        <select name="campo" required>
            <option value="dni">DNI</option>
            <option value="equipo">Equipo</option>
            <option value="posicion">Posición</option>
        </select>
        <br><br>
        
        Valor a buscar: <input type="text" name="valor" required><br><br>
        
        <input type="submit" name="buscar" value="Buscar">
    </form>
    
    <?php
    if($busqueda_realizada){
        if($result && $result->num_rows > 0){
            echo "<h2>Resultados encontrados:</h2>";
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
            echo "<p style='color: red;'>No se encontraron jugadores con ese criterio.</p>";
        }
    }
    ?>
    
    <br>
    <a href="index.php">Volver al menú</a>
</body>
</html>