<!-- Hecho en clase -->
<?php
if(isset($_POST['enviar'])){
    if(empty($_POST['nombre'])){
        $errores[]= 'nombre';

    }if(empty($_POST['apell'])){
        $errores[]= 'apell';

    }if(empty($_POST['modulos'])){
        $errores[]= 'modulos';

    }

}
if(isset($_POST['enviar']) && empty($errores)){
    echo $_POST['nombre']. " | " . $_POST['apell'];
    foreach($array as $key => $value){
        echo $value;
    }

}else{




?>


<?php

?>
<form action="" method="post">
        Nombre: <input type="text" name="nombre" value="<?php if(empty($_POST['enviar']) && !in_array('nombre',$errores)) echo $_POST['nombre'];?>"><?php if(isset($_POST['enviar']) && in_array('nombre',$errores)) echo '<span style=color:red> El nombre está vacío </span> '; ?><br><br>
        Apellidos: <input type="text" name="apell" value="<?php if(empty($_POST['enviar']) && !in_array('apell',$errores)) echo $_POST['apell'];?>"><?php if(isset($_POST['enviar']) && in_array('apell',$errores)) echo '<span style=color:red> El apellido está vacío </span> '; ?><br><br>
        modulos:<?php if(isset($_POST['enviar']) && in_array('modulos',$errores)) echo '<span style=color:red> Los modulos estan vacios </span> '; ?><br>
        <input type="checkbox" name="modulos[]" value="DWES" <?php if(empty($_POST['enviar']) && !in_array('modulos',$errores)) echo 'checked';?>>Desarrollo web entorno servidor <br><br>
        <input type="checkbox" name="modulos[]" value="DWEC" <?php if(empty($_POST['enviar']) && !in_array('modulos',$errores)) echo 'checked';?>> Desarrollo web entorno cliente<br><br>
        <input type="checkbox" name="modulos[]" value="DIW" <?php if(empty($_POST['enviar']) && !in_array('modulos',$errores)) echo 'checked';?>>Desarrollo interfaces web <br><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
<?php
    }

?>
<form action="" method="post">
        Nombre: <input type="text" name="nombre"><br><br>
        Apellidos: <input type="text" name="apell">
        <br><br>
        modulos:
        <br>
        <input type="checkbox" name="modulos[]" value="DWES" >Desarrollo web entorno servidor <br><br>
        <input type="checkbox" name="modulos[]" value="DWEC" > Desarrollo web entorno cliente<br><br>
        <input type="checkbox" name="modulos[]" value="DIW" >Desarrollo interfaces web <br><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
