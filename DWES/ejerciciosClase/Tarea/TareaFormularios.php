<?php
$errores = array();

if(isset($_POST['enviar'])){
    if(empty($_POST['nombre'])){
        $errores[] = 'nombre'; 
    }
    if(empty($_POST['apell'])){
        $errores[] = 'apell'; 
    }    
    if(empty($_POST['provincia'])){
        $errores[] = 'provincia'; 
    }
    if(empty($_POST['sexo'])){
        $errores[] = 'sexo'; 
    }
    if(empty($_POST['edad'])){
        $errores[] = 'edad'; 
    }
    if(empty($_POST['civil'])){
        $errores[] = 'civil'; 
    }
    if(empty($_POST['aficiones'])){
        $errores[] = 'aficiones'; 
    }
    if(empty($_POST['estudios'])){
        $errores[] = 'estudios'; 
    }
}

if(isset($_POST['enviar']) && empty($errores)){
    echo "<h3>Datos recibidos:</h3>";
    echo "Nombre: " . $_POST['nombre'] . "<br>";
    echo "Apellidos: " . $_POST['apell'] . "<br>";
    echo "Provincia: " . $_POST['provincia'] . "<br>";
    echo "Sexo: " . $_POST['sexo'] . "<br>";
    echo "Edad: ". $_POST['edad'] . " años <br>";
    echo "Estado civil: " . $_POST['civil'] . "<br>";
    echo "Aficiones:<br>";
    foreach($_POST['aficiones'] as $aficion){
        echo "- " . $aficion . "<br>";
    }
    echo "Estudios seleccionados:<br>";
    foreach($_POST['estudios'] as $estudio){
        echo "- " . $estudio . "<br>";
    }
    echo "<br><a href=''>Volver al formulario</a>";
}
else{
?>

<form action="" method="post">
    Nombre: <input type="text" name="nombre"><br><br>
    Apellidos: <input type="text" name="apell"><br><br>
    
    Provincia: <select name="provincia" id="provincia">
                    <option value="" disabled selected>Seleccione una provincia</option>
                    <option value="Malaga">Malaga</option>
                    <option value="Cordoba">Cordoba</option>
                    <option value="Jaen">Jaen</option>
                    <option value="Almeria">Almeria</option>
                    <option value="Sevilla">Sevilla</option>
                    <option value="Granada">Granada</option>
                    <option value="Cadiz">Cadiz</option>
                    <option value="Huelva">Huelva</option>
                </select>
                <br><br>
    
    Sexo: <input type="radio" name="sexo" value="Hombre">Hombre
          <input type="radio" name="sexo" value="Mujer">Mujer
          <br><br>
    
    Edad: <input type="number" name="edad"><br><br>
    
    Estado civil: <input type="radio" name="civil" value="Casado">Casado
                  <input type="radio" name="civil" value="Soltero">Soltero
                  <input type="radio" name="civil" value="Otro">Otro
                  <br><br>
    
    Aficiones: <input type="checkbox" name="aficiones[]" value="Cine">Cine
               <input type="checkbox" name="aficiones[]" value="Deporte">Deporte
               <input type="checkbox" name="aficiones[]" value="Lectura">Lectura
               <input type="checkbox" name="aficiones[]" value="Musica">Musica
               <input type="checkbox" name="aficiones[]" value="TV">TV
               <br><br>
    
    Estudios: <select multiple name="estudios[]" id="estudios">
                  <option value="ESO">ESO</option>
                  <option value="Bach">Bachillerato</option>
                  <option value="CFGM">CFGM</option>
                  <option value="CFGS">CFGS</option>
                  <option value="Uni">Universidad</option>
              </select>
              <br><br>
    
    <input type="submit" name="enviar" value="Enviar">
</form>

<?php
}
?>