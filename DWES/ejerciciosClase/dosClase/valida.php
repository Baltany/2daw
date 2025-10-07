<?php
if (isset($_POST['enviar'])){
    if(!empty($_POST['nombre']) && !empty($_POST['apell']) && !empty($_POST['modulos'])){
        echo "Nombre: ".$_POST['nombre']."<br>";
        echo "Apellidos: ".$_POST['apell']."<br>";
        echo "Modulos: <br> ";
        foreach($_POST['modulos'] as $valor){
            echo $valor."<br>";
        }
        echo '<br> <a href="">Volver al formulario</a>';
    }
    else{
        echo "Hay errores en el formulario";
?>
<form action="" method="post">
        Nombre: <input type="text" name="nombre"><?php if(empty($_POST['nombre'])) echo "<span style = color:red>El nombre no debe de estar en blanco</span>"?><br><br>
        Apellidos: <input type="text" name="apell"><?php if(empty($_POST['apell'])) echo "<span style = color:red>Los apellidos no deben de estar en blanco</span>"?>
        <br><br>
        modulos:<?php if(empty($_POST['modulos'])) echo "<span style = color:red>Tienes que elegir al menos un modulo</span>"?><br>
        <input type="checkbox" name="modulos[]" value="DWES">Desarrollo web entorno servidor <br><br>
        <input type="checkbox" name="modulos[]" value="DWEC"> Desarrollo web entorno cliente<br><br>
        <input type="checkbox" name="modulos[]" value="DIW">Desarrollo interfaces web <br><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
<?php
    }
}else{
?>
<form action="" method="post">
        Nombre: <input type="text" name="nombre"><br><br>
        Apellidos: <input type="text" name="apell">
        <br><br>
        modulos:
        <br>
        <input type="checkbox" name="modulos[]" value="DWES">Desarrollo web entorno servidor <br><br>
        <input type="checkbox" name="modulos[]" value="DWEC"> Desarrollo web entorno cliente<br><br>
        <input type="checkbox" name="modulos[]" value="DIW">Desarrollo interfaces web <br><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
<?php
}
?>