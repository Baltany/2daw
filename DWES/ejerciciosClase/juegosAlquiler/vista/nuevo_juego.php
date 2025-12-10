<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Juego</title>
</head>
<body>
    <h1>AÑADIR NUEVO JUEGO</h1>
    
    <?php
    if(isset($mensaje)){
        echo "<p style='color: green;'><b>$mensaje</b></p>";
    }
    ?>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <b>Código:</b> <input type="text" name="codigo" required><br><br>
        
        <b>Nombre del juego:</b> <input type="text" name="nombre" required><br><br>
        
        <b>Consola:</b> <input type="text" name="consola" required><br><br>
        
        <b>Año:</b> <input type="number" name="anno" min="1980" max="2030" required><br><br>
        
        <b>Precio (€):</b> <input type="number" name="precio" min="0" required><br><br>
        
        <b>Imagen:</b> <input type="file" name="imagen" accept="image/*"><br><br>
        
        <b>Descripción:</b><br>
        <textarea name="descripcion" rows="5" cols="50" required></textarea><br><br>
        
        <input type="submit" name="crear" value="CREAR JUEGO">
    </form>
    
    <br>
    <a href="index.php?accion=menu"><button>Volver al menú</button></a>
</body>
</html>