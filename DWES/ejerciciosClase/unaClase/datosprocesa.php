<!-- Dejando "" hacemos solicitud a nosotros mismos,o podemos usar $_SERVER -->
<?php
if(!isset($_POST['enviar'])){
?>

<form action="" method="POST">
        <!-- Nuestro name es nuestra variable que recogeremos en php -->
        Nombre: <input type="text" name="nombre"><br>
        Apellidos: <input type="text" name="apell"> <br>
        <!-- Se usa un array para guardar los controles de modulos ya que el usuario puede elegir mas de una opcion checkbox es multiseleccio,radius es solo una opcion -->
        Modulo <input type="checkbox" name="modulos[]" value="DWES"> Desarrollo web entorno servidor <br>
        Modulo <input type="checkbox" name="modulos[]" value="DWEC"> Desarrollo web entorno cliente <br>
        Modulo <input type="checkbox" name="modulos[]" value="DIW"> Diseño de interfaces web <br>
        <input type="submit" name="enviar" value="Enviar">

</form>


<?php
// muestra la ruta del archivo
//echo $_SERVER('PHP_SELF');
// Cierre del if de arriba para mostrar o no mostrar el formulario
}


echo "Datos recibidos";
echo "<br>";

if(isset($_POST['enviar'])){
    echo "Nombre: ",$_POST['nombre']."<br>";
    echo "Apellidos: ",$_POST['apell']. "<br>";
    
    foreach($_POST['modulos'] as $valor){
        echo $valor ."<br>"; 
    }
    
}else{
    echo "No has enviado datos al formulario";

}


?>