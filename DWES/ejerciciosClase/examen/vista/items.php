<?php
session_start();
if(!isset($_COOKIE['usuario_id'])){
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Items</title>
</head>
<body>
    <h1>Gestión de Items</h1>
    
    <a href="index.php">Volver al Panel</a> | <a href="crear_item.php">Crear Nuevo Item</a> | <a href="logout.php">Cerrar Sesión</a>
    
    <hr>
    
    <h2>Lista de Items</h2>
    
    <?php
    require_once '../model/Item.php';
    require_once '../controller/ItemController.php';
    
    if(isset($_GET['eliminar'])){
        $id=$_GET['eliminar'];
        if(itemController::eliminar($id)){
            echo "<p style='color:green;'>Item eliminado correctamente</p>";
        }else{
            echo "<p style='color:red;'>Error al eliminar el item</p>";
        }
    }
    
    $items=itemController::mostrar();
    if($items){
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>Provincia</th><th>Sexo</th><th>Edad</th><th>Estado Civil</th><th>Acciones</th></tr>";
        foreach($items as $i){
            echo "<tr>";
            echo "<td>".$i->id."</td>";
            echo "<td>".$i->nombre."</td>";
            echo "<td>".$i->apellidos."</td>";
            echo "<td>".$i->provincia."</td>";
            echo "<td>".$i->sexo."</td>";
            echo "<td>".$i->edad."</td>";
            echo "<td>".$i->estado_civil."</td>";
            echo "<td>";
            echo "<a href='editar_item.php?id=".$i->id."'>Editar</a> | ";
            echo "<a href='items.php?eliminar=".$i->id."' onclick='return confirm(\"¿Estás seguro?\")'>Eliminar</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "<p>No hay items registrados</p>";
    }
    ?>
</body>
</html>
