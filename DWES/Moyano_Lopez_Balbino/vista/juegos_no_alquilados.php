<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juegos Disponibles</title>
</head>
<body>
    <h1>LISTADO DE JUEGOS DISPONIBLES (NO ALQUILADOS)</h1>
    
    <?php
    $juegos = JuegoController::listarNoAlquilados();
    
    if($juegos){
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Imagen</th><th>Código</th><th>Nombre</th><th>Consola</th><th>Año</th><th>Precio</th></tr>";
        
        foreach($juegos as $j){
            echo "<tr>";
            echo "<td><a href='index.php?accion=detalle&codigo=$j->Codigo'><img src='$j->Imagen' width='100'></a></td>";
            echo "<td>$j->Codigo</td>";
            echo "<td>$j->Nombre_juego</td>";
            echo "<td>$j->Nombre_consola</td>";
            echo "<td>$j->Anno</td>";
            echo "<td>$j->Precio €</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }else{
        echo "<p>No hay juegos disponibles actualmente</p>";
    }
    ?>
    
    <br>
    <a href="index.php?accion=menu"><button>Volver al menú</button></a>
</body>
</html>