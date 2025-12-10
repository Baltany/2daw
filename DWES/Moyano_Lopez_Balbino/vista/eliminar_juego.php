<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Juego</title>
</head>
<body>
    <h1>ELIMINAR JUEGO</h1>
    
    <?php
    if(isset($mensaje)){
        echo "<p style='color: green;'><b>$mensaje</b></p>";
    }
    ?>
    
    <h3>Seleccione el juego a eliminar:</h3>
    
    <?php
    $juegos = JuegoController::listarTodos();
    
    if($juegos){
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Imagen</th><th>Código</th><th>Nombre</th><th>Consola</th><th>Estado</th><th>Acción</th></tr>";
        
        foreach($juegos as $j){
            echo "<tr>";
            echo "<td><img src='$j->Imagen' width='80'></td>";
            echo "<td>$j->Codigo</td>";
            echo "<td>$j->Nombre_juego</td>";
            echo "<td>$j->Nombre_consola</td>";
            echo "<td>" . ($j->Alguilado == 'SI' ? 'ALQUILADO' : 'DISPONIBLE') . "</td>";
            echo "<td>";
            
            if($j->Alguilado == 'NO'){
                echo "<form action='' method='POST' onsubmit='return confirm(\"¿Está seguro de eliminar este juego?\")'>";
                echo "<input type='hidden' name='codigo' value='$j->Codigo'>";
                echo "<input type='submit' name='eliminar' value='ELIMINAR'>";
                echo "</form>";
            }else{
                echo "<i>No se puede eliminar (está alquilado)</i>";
            }
            
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }else{
        echo "<p>No hay juegos en la base de datos</p>";
    }
    ?>
    
    <br>
    <a href="index.php?accion=menu"><button>Volver al menú</button></a>
</body>
</html>