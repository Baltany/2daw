<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú</title>
</head>
<body>
    <h1>MENÚ PRINCIPAL</h1>
    <?php if($cliente): ?>
        <h2>Bienvenido: <?php echo $cliente->Nombre . " " . $cliente->Apellidos; ?></h2>
        
        <h3>Opciones:</h3>
        <ul>
            <li><a href="index.php?accion=listado_juegos">Listado de juegos</a></li>
            <li><a href="index.php?accion=juegos_alquilados">Listado de juegos alquilados</a></li>
            <li><a href="index.php?accion=juegos_no_alquilados">Listado de juegos NO alquilados</a></li>
            <li><a href="index.php?accion=mis_alquileres">Mis juegos alquilados</a></li>
            
            <?php if($cliente->Tipo == 'admin'): ?>
                <hr>
                <h3>Opciones de administrador:</h3>
                <li><a href="index.php?accion=nuevo_juego">Añadir nuevo juego</a></li>
                <li><a href="index.php?accion=modificar_juego">Modificar juego</a></li>
                <li><a href="index.php?accion=eliminar_juego">Eliminar juego</a></li>
            <?php endif; ?>
        </ul>
        
        <br>
        <a href="index.php?accion=logout"><button>Salir</button></a>
    <?php else: ?>
        <p>Error: Sesión no válida</p>
        <a href="index.php?accion=login"><button>Volver al login</button></a>
    <?php endif; ?>
</body>
</html>