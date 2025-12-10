<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Juego</title>
</head>
<body>
    <h1>DETALLE DEL JUEGO</h1>
    
    <?php
    // Obtener cliente de la sesión si existe
    $clienteActual = isset($cliente) ? $cliente : false;
    
    if(isset($mensaje)){
        echo "<p style='color: green;'><b>$mensaje</b></p>";
    }
    
    if(isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
        $juego = JuegoController::buscar($codigo);
        
        if($juego){
            echo "<table border='1' cellpadding='10'>";
            echo "<tr><td><img src='$juego->Imagen' width='200'></td></tr>";
            echo "<tr><td><b>Código:</b> $juego->Codigo</td></tr>";
            echo "<tr><td><b>Nombre:</b> $juego->Nombre_juego</td></tr>";
            echo "<tr><td><b>Consola:</b> $juego->Nombre_consola</td></tr>";
            echo "<tr><td><b>Año:</b> $juego->Anno</td></tr>";
            echo "<tr><td><b>Precio:</b> $juego->Precio €</td></tr>";
            echo "<tr><td><b>Descripción:</b> $juego->descripcion</td></tr>";
            
            // Verificar si está alquilado
            if($juego->Alguilado == 'SI'){
                echo "<tr><td><b>Estado:</b> ALQUILADO</td></tr>";
                
                // Obtener detalles del alquiler
                $alquiler = AlquilerController::detalleAlquiler($codigo);
                if($alquiler){
                    echo "<tr><td><b>Fecha de alquiler:</b> $alquiler->Fecha_alquiler</td></tr>";
                    echo "<tr><td><b>Fecha de devolución prevista:</b> $alquiler->Fecha_devol_prevista</td></tr>";
                }
            }else{
                echo "<tr><td><b>Estado:</b> DISPONIBLE</td></tr>";
                
                // Mostrar botón para alquilar solo si está logueado
                if($clienteActual){
                    echo "<tr><td>";
                    echo "<form action='' method='POST'>";
                    echo "<input type='hidden' name='cod_juego' value='$juego->Codigo'>";
                    echo "<input type='submit' name='alquilar' value='ALQUILAR JUEGO'>";
                    echo "</form>";
                    echo "</td></tr>";
                }else{
                    echo "<tr><td><a href='index.php?accion=login&mensaje=Debe loguearse para alquilar'>Debe loguearse para alquilar</a></td></tr>";
                }
            }
            
            echo "</table>";
        }else{
            echo "<p>Juego no encontrado</p>";
        }
    }else{
        echo "<p>No se especificó ningún juego</p>";
    }
    ?>
    
    <br>
    <?php if($clienteActual): ?>
        <a href="index.php?accion=menu"><button>Volver al menú</button></a>
    <?php else: ?>
        <a href="index.php"><button>Volver a inicio</button></a>
    <?php endif; ?>
</body>
</html>