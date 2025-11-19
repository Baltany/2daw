<?php
require_once 'funciones.php';

$mensaje = "";
$matricula = $marca = $plazas = "";
$errores = [];

if(isset($_POST['enviar'])){
    $matricula = strtoupper(trim($_POST['matricula']));
    $marca = trim($_POST['marca']);
    $plazas = $_POST['plazas'];

    // validadciones correspondientes de los campos matriculas,plazas...
    if(empty($matricula) || strlen($matricula) != 6){
        $errores[] = "La matrícula debe tener exactamente 6 caracteres.";
    }
    
    if(empty($marca)){
        $errores[] = "La marca no puede estar vacía.";
    }
    
    if(empty($plazas) || !is_numeric($plazas) || $plazas <= 0){
        $errores[] = "El número de plazas debe ser un número válido mayor que 0.";
    }
    
    // sino existen errores insertamos
        if(empty($errores)){
        if(addBus($matricula, $marca, $plazas)){
            $mensaje = "<p>Autobús añadido correctamente</p>";
            $matricula = $marca = $plazas = "";
        }else{
            $mensaje = "<p>Error: La matrícula ya existe</p>";
        }
    }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir bus</title>
</head>
<body>
    <?php
    echo $mensaje ."<br><br><br><br>";

    if(!empty($errores)){
        echo "<div>";
        echo "<h3>Errores:</h3>";
        echo "<ul>";
        foreach($errores as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
    ?>
    <form action="" method="post">
        Matrícula: <input type="text" name="matricula" value="<?php echo $matricula; ?>" maxlength="6" placeholder="1234ABC" required><br><br>
        
        Marca: <input type="text" name="marca" value="<?php echo $marca; ?>" required><br><br>
        
        Nº plazas: <input type="number" name="plazas" value="<?php echo $plazas; ?>" min="1" required><br><br>
        
        <input type="submit" name="enviar" value="Añadir">
        <a href="index.php">Volver al menu</a>
    </form>



</body>
</html>