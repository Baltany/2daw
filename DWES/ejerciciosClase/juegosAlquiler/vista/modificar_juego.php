<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Juego</title>
</head>
<body>
    <h1>MODIFICAR JUEGO</h1>
    
    <?php
    if(isset($mensaje)){
        echo "<p style='color: green;'><b>$mensaje</b></p>";
    }
    ?>
    
    <h3>Seleccione el juego a modificar:</h3>
    
    <?php
    $juegos = JuegoController::listarTodos();
    
    if($juegos){
        echo "<form action='' method='GET'>";
        echo "<input type='hidden' name='accion' value='modificar_juego'>";
        echo "<select name='codigo' onchange='this.form.submit()'>";
        echo "<option value=''>-- Seleccione un juego --</option>";
        foreach($juegos as $j){
            $selected = (isset($_GET['codigo']) && $_GET['codigo'] == $j->Codigo) ? "selected" : "";
            echo "<option value='$j->Codigo' $selected>$j->Nombre_juego ($j->Codigo)</option>";
        }
        echo "</select>";
        echo "</form>";
        
        // Si se ha seleccionado un juego, mostrar formulario
        if(isset($_GET['codigo']) && !empty($_GET['codigo'])){
            $juego = JuegoController::buscar($_GET['codigo']);
            
            if($juego){
                echo "<br><h3>Modificar datos del juego:</h3>";
                echo "<form action='' method='POST' enctype='multipart/form-data'>";
                echo "<input type='hidden' name='codigo' value='$juego->Codigo'>";
                
                echo "<b>Código:</b> <input type='text' value='$juego->Codigo' disabled><br><br>";
                
                echo "<b>Nombre del juego:</b> <input type='text' name='nombre' value='$juego->Nombre_juego' required><br><br>";
                
                echo "<b>Consola:</b> <input type='text' name='consola' value='$juego->Nombre_consola' required><br><br>";
                
                echo "<b>Año:</b> <input type='number' name='anno' value='$juego->Anno' min='1980' max='2030' required><br><br>";
                
                echo "<b>Precio (€):</b> <input type='number' name='precio' value='$juego->Precio' min='0' required><br><br>";
                
                echo "<b>Imagen actual:</b><br>";
                echo "<img src='$juego->Imagen' width='150'><br>";
                echo "<b>Nueva imagen (dejar vacío para mantener actual):</b> <input type='file' name='imagen' accept='image/*'><br><br>";
                
                echo "<b>Descripción:</b><br>";
                echo "<textarea name='descripcion' rows='5' cols='50' required>$juego->descripcion</textarea><br><br>";
                
                echo "<input type='submit' name='modificar' value='MODIFICAR JUEGO'>";
                echo "</form>";
            }
        }
    }else{
        echo "<p>No hay juegos en la base de datos</p>";
    }
    ?>
    
    <br>
    <a href="index.php?accion=menu"><button>Volver al menú</button></a>
</body>
</html>