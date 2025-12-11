<?php
session_start();
if(!isset($_COOKIE['usuario_id'])){
    header("Location:login.php");
}

require_once '../model/Item.php';
require_once '../controller/ItemController.php';

if(!isset($_GET['id'])){
    header("Location:items.php");
}

$item=itemController::buscar($_GET['id']);
if(!$item){
    echo "Item no encontrado";
    echo "<a href='items.php'>Volver</a>";
    exit();
}


if(isset($_POST['actualizar'])){
    $errores=array();
    
    $id=$_POST['id'];
    $nombre=trim($_POST['nombre']);
    $apellidos=trim($_POST['apellidos']);
    $provincia=$_POST['provincia'];
    $sexo=isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $edad=isset($_POST['edad']) ? $_POST['edad'] : '';
    $estado_civil=$_POST['estado_civil'];
    $aficiones=isset($_POST['aficiones']) ? implode(', ',$_POST['aficiones']) : '';
    $estudios=isset($_POST['estudios']) ? implode(', ',$_POST['estudios']) : '';
    
    if(empty($nombre)){
        $errores[]="El nombre es obligatorio";
    }
    
    if(empty($apellidos)){
        $errores[]="Los apellidos son obligatorios";
    }
    
    if(empty($provincia)){
        $errores[]="Debes seleccionar una provincia";
    }
    
    if(empty($errores)){
        $i=new Item($id,$nombre,$apellidos,$provincia,$sexo,$edad,$estado_civil,$aficiones,$estudios);
        
        if(itemController::actualizar($i)){
            echo "<br>Item actualizado correctamente<br>";
            echo "<a href='items.php'>Ver todos los items</a>";
        }else{
            $errores[]="Error al actualizar el item";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Item</title>
</head>
<body>
    <h1>Editar Item</h1>
    
    <a href="items.php">Volver a Items</a>
    
    <hr>
    
    <?php if(isset($errores) && !empty($errores)): ?>
        <div style="color:red;">
            <h3>Errores:</h3>
            <ul>
                <?php foreach($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $item->id; ?>">
        
        Nombre: <input type="text" name="nombre" required 
               value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : $item->nombre; ?>"><br><br>
        
        Apellidos: <input type="text" name="apellidos" required 
               value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : $item->apellidos; ?>"><br><br>
        
        Provincia: <select name="provincia" required>
            <option value="">Seleccione una provincia</option>
            <?php 
            $provincias=array('Malaga','Cordoba','Jaen','Almeria','Sevilla','Granada','Cadiz','Huelva');
            $prov_seleccionada=isset($_POST['provincia']) ? $_POST['provincia'] : $item->provincia;
            foreach($provincias as $p){
                $selected=($prov_seleccionada==$p) ? 'selected' : '';
                echo "<option value='$p' $selected>$p</option>";
            }
            ?>
        </select><br><br>
        
        Sexo: 
        <?php
        $sexo_seleccionado=isset($_POST['sexo']) ? $_POST['sexo'] : $item->sexo;
        ?>
        <input type="radio" name="sexo" value="Hombre" <?php echo ($sexo_seleccionado=='Hombre') ? 'checked' : ''; ?>> Hombre
        <input type="radio" name="sexo" value="Mujer" <?php echo ($sexo_seleccionado=='Mujer') ? 'checked' : ''; ?>> Mujer
        <input type="radio" name="sexo" value="Otro" <?php echo ($sexo_seleccionado=='Otro') ? 'checked' : ''; ?>> Otro<br><br>
        
        Edad: <input type="text" name="edad" 
               value="<?php echo isset($_POST['edad']) ? $_POST['edad'] : $item->edad; ?>"><br><br>
        
        Estado Civil: <select name="estado_civil">
            <?php
            $estados=array(''=>'Seleccione','Soltero'=>'Soltero/a','Casado'=>'Casado/a','Divorciado'=>'Divorciado/a','Viudo'=>'Viudo/a');
            $estado_seleccionado=isset($_POST['estado_civil']) ? $_POST['estado_civil'] : $item->estado_civil;
            foreach($estados as $valor=>$texto){
                $selected=($estado_seleccionado==$valor) ? 'selected' : '';
                echo "<option value='$valor' $selected>$texto</option>";
            }
            ?>
        </select><br><br>
        
        Aficiones:<br>
        <?php
        $aficiones_item=explode(', ',$item->aficiones);
        $aficiones_disponibles=array('Cine','Deporte','Lectura','Musica','TV','Viajar');
        foreach($aficiones_disponibles as $af){
            $checked=(isset($_POST['aficiones']) && in_array($af,$_POST['aficiones'])) || (!isset($_POST['aficiones']) && in_array($af,$aficiones_item)) ? 'checked' : '';
            echo "<input type='checkbox' name='aficiones[]' value='$af' $checked> $af ";
        }
        ?>
        <br><br>
        
        Estudios:<br>
        <select name="estudios[]" multiple size="8">
            <?php
            $estudios_item=explode(', ',$item->estudios);
            $estudios_disponibles=array('ESO','Bachillerato','CFGM','CFGS','Universidad','Postgrado','Master','Doctorado');
            foreach($estudios_disponibles as $est){
                $selected=(isset($_POST['estudios']) && in_array($est,$_POST['estudios'])) || (!isset($_POST['estudios']) && in_array($est,$estudios_item)) ? 'selected' : '';
                echo "<option value='$est' $selected>$est</option>";
            }
            ?>
        </select><br><br>
        
        <input type="submit" name="actualizar" value="Actualizar Item">
    </form>
</body>
</html>
