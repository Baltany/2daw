<?php
session_start();

if(!isset($_SESSION['profesor'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Profesor.php';
require_once '../model/Curso.php';
require_once '../model/Alumno.php';
require_once '../controller/CursoController.php';
require_once '../controller/AlumnoController.php';


$profesor = unserialize($_SESSION['profesor']);




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu-Balbino</title>
</head>

<body>
    <h1>Panel de <?php echo $profesor->dni_p; ?></h1>

    <p>Bienvenido/a profesor: <?php echo $profesor->nombre ." ". $profesor->apellidos; ?>
        <a href="logout.php">Cerrar Sesión</a>
    </p>

    <hr>

    <h2>MENÚ</h2>
    <form action="" method="post">
        Curso: <select name="curso">
            <option value="">Seleccione un curso</option>
            <option value="1º ESO"
                <?php echo (isset($_POST['curso']) && $_POST['curso'] == '1ºESO') ? 'selected' : ''; ?>>
                1º ESO
            </option>
            <option value="2ª ESO"
                <?php echo (isset($_POST['curso']) && $_POST['curso'] == '2ºESO') ? 'selected' : ''; ?>>2º ESO
            </option>
            <option value="3º ESO"
                <?php echo (isset($_POST['curso']) && $_POST['curso'] == '3ºESO') ? 'selected' : ''; ?>>3º
                ESO
            </option>
            <option value="4º ESO"
                <?php echo (isset($_POST['curso']) && $_POST['curso'] == '4ºESO') ? 'selected' : ''; ?>>4º ESO
            </option>
        </select><br><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>

    <br>
    <?php
if(isset($_POST['enviar'])){
    $curso = $_POST['curso'];
    if(empty($curso)){
        $error = "El curso es obligatorio";
    }else{
        $c = CursoController::buscarPorId($curso);
        if(!$c){
            $error = "El curso no existe";
        }else{
            if($c->totalpartes===0){
                echo "El curso seleccionado no tiene ningun parte";
            }else{
                echo "El curso seleccionado tiene ".$c->totalpartes ." partes";

                echo "<h3>Listado de alumnos con partes:</h3>";

                $alumnos = AlumnoController::mostrarAlumnos($c->id_curso);
                echo "<table border='1'>";
                echo "<tr>";
                echo "<td>";
                echo "Alumnos";
                echo "</td>";
                echo "<td>";
                echo "Acciones";
                echo "</td>";
                echo "</tr>";
                foreach ($alumnos as $alumno){
                    echo "<tr>";
                    echo "<td>";
                    echo $alumno->nombre ." " . $alumno->apellidos;
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='nuevo.php?id=$alumno->dni_a'>Nuevo parte</a> | <a href='historial.php?id=$alumno->dni_a'>Historial</a>";
                    echo "</td>";
                    echo "</tr>";
                }

    echo "</table>";


    }
    }


    }

    }

    ?>




</body>

</html>