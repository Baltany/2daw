<?php
echo "Datos recibidos";
echo "<br>";

if(isset($_POST['enviar'])){
    echo "Nombre: ",$_POST['nombre']."<br>";
    echo "Apellidos: ",$_POST['apell']. "<br>";
    
    foreach($_POST['modulos'] as $valor){
        echo $valor ."<br>"; 
    }
    
    $nom = $_POST['nombre'];
    $apell = $_POST['apell'];
}else{
    echo "No has enviado datos al formulario";
    echo "<a href=formulario.php>Volver</a>";
}


?>

<a href="formulario.php?n=<?=$nom?>&a=<?=$apell?>">Volver</a>