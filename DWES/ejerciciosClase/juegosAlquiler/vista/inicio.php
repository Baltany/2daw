<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alquiler Juegos - Inicio</title>
</head>
<body>
    <h1>ALQUILER DE JUEGOS PARA CONSOLAS</h1>
    
    <?php if($cliente): ?>
        <p>Bienvenido: <?php echo $cliente->Nombre; ?> 
        <a href="index.php?accion=logout"><button>Salir</button></a>
        <a href="index.php?accion=menu"><button>Ir al menú</button></a></p>
    <?php else: ?>
        <a href="index.php?accion=login"><button>Login</button></a>
    <?php endif; ?>
    
    <h2>Listado de todos los juegos:</h2>
    
    <?php
    $juegos = JuegoController::listarTodos();
    if($juegos){
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Imagen</th><th>Nombre</th><th>Consola</th><th>Año</th><th>Precio</th><th>Estado</th></tr>";
        foreach($juegos as $j){
            $estilo = ($j->Alguilado == 'SI') ? "style='filter: grayscale(100%);'" : "";
            echo "<tr>";
            echo "<td><a href='index.php?accion=detalle&codigo=$j->Codigo'><img src='$j->Imagen' width='100' $estilo></a></td>";
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
</body>
</html>