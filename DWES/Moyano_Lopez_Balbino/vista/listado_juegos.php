<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Juegos</title>
</head>
<body>
    <h1>LISTADO DE TODOS LOS JUEGOS</h1>
    
    <?php
    $juegos = JuegoController::listarTodos();
    if($juegos){
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Imagen</th><th>Código</th><th>Nombre</th><th>Consola</th><th>Año</th><th>Precio</th><th>Estado</th></tr>";
        foreach($juegos as $j){
            $estilo = ($j->Alguilado == 'SI') ? "style='filter: grayscale(100%);'" : "";
            echo "<tr>";
            echo "<td><a href='index.php?accion=detalle&codigo=$j->Codigo'><img src='$j->Imagen' width='100' $estilo></a></td>";
            echo "<td>$j->Codigo</td>";
            echo "<td>$j->Nombre_juego</td>";
            echo "<td>$j->Nombre_consola</td>";
            echo "<td>$j->Anno</td>";
            echo "<td>$j->Precio €</td>";
            echo "<td>" . ($j->Alguilado == 'SI' ? 'ALQUILADO' : 'DISPONIBLE') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "<p>No hay juegos disponibles</p>";
    }
    ?>
    
    <br>
    <a href="index.php?accion=menu"><button>Volver al menú</button></a>
</body>
</html>