<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juegos Alquilados</title>
</head>
<body>
    <h1>LISTADO DE JUEGOS ALQUILADOS</h1>
    
    <?php
    $alquileres = AlquilerController::listarAlquilados();
    
    if($alquileres){
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Código</th><th>Juego</th><th>Cliente</th><th>Fecha Alquiler</th></tr>";
        
        foreach($alquileres as $a){
            echo "<tr>";
            echo "<td>$a->Cod_juego</td>";
            echo "<td>$a->Nombre_juego</td>";
            echo "<td>$a->Cliente</td>";
            echo "<td>$a->Fecha_alquiler</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }else{
        echo "<p>No hay juegos alquilados actualmente</p>";
    }
    ?>
    
    <br>
    <a href="index.php?accion=menu"><button>Volver al menú</button></a>
</body>
</html>