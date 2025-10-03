<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario </title>
</head>
<body>
    <form action="procesa.php" method="POST">
        <!-- Nuestro name es nuestra variable que recogeremos en php -->
        Nombre: <input type="text" name="nombre"><br>
        Apellidos: <input type="text" name="apell"> <br>
        <!-- Se usa un array para guardar los controles de modulos ya que el usuario puede elegir mas de una opcion checkbox es multiseleccio,radius es solo una opcion -->
        Modulo <input type="checkbox" name="modulos[]" value="DWES"> Desarrollo web entorno servidor <br>
        Modulo <input type="checkbox" name="modulos[]" value="DWEC"> Desarrollo web entorno cliente <br>
        Modulo <input type="checkbox" name="modulos[]" value="DIW"> Diseño de interfaces web <br>
        <input type="submit" name="enviar" value="Enviar">

    </form>
    <a href="opciones.php?n=1">Opcion 1</a><br>
    <a href="opciones.php?n=2">Opcion 2</a><br>
    <a href="opciones.php?n=3">Opcion 3</a><br>

    <?php
    var_dump($_GET);
    ?>
</body>
</html>