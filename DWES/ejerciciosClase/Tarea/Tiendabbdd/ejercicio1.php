<!-- Crea una página web en la que se muestre el stock existente de un determinado producto en
cada una de las tiendas. Para seleccionar el producto concreto utiliza un cuadro de selección 
dentro de un formulario en esa misma página, en el que se muestre el nombre de los
todos los productos que hay -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1 | Balbino</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="encabezado">
        <h1>Ejercicio : Conjuntos de resultados en MySQLi</h1>
        <form action="" method="post">
            Producto: <select name="producto">
                <option value="">-- Selecciona un producto --</option>
                <?php
                    try{
                        $connection = new mysqli("localhost", "dwes", "abc123.", "dwes");
                        $connection -> set_charset("utf8mb4");
                        $sql = "SELECT cod, nombre_corto FROM producto ORDER BY nombre_corto";
                        $result = $connection -> query($sql);

                        // Rellenamos el select con los datos obtenidos
                        while($fila = $result->fetch_assoc()){
                            $seleccionado = (isset($_POST['producto']) && $_POST['producto'] == $fila['cod']) ? 'selected' : '';
                            echo "<option value='{$fila['cod']}' $seleccionado>{$fila['nombre_corto']}</option>";
                        }

                    }catch(mysqli_sql_exception $e){
                        echo "<option value=''>Error al cargar productos</option>";
                    }
                ?>
            <input type="submit" name="enviar" value="Mostrar Stock">
        </form>
    </div>
    <div id="contenido">
        <!-- Si se ha enviado el formulario entonces mostramos el stock -->
        <?php
            if(isset($_POST['enviar']) && !empty($_POST['producto'])){
                try{
                    $producto = $_POST['producto'];
                    $sql = "SELECT t.nombre AS tienda, s.unidades, p.nombre_corto
                        FROM stock s
                        INNER JOIN tienda t ON s.tienda = t.cod
                        INNER JOIN producto p ON s.producto = p.cod
                        WHERE s.producto = ?
                        ORDER BY t.cod";
                
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("s", $producto);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        // Obtener el nombre del producto
                        $primera_fila = $result->fetch_assoc();
                        $nombre_producto = $primera_fila['nombre_corto'];
                        
                        echo "<h2>Stock del producto: $nombre_producto</h2>";
                        
                        // Mostrar la primera tienda
                        echo "Tienda: {$primera_fila['tienda']} y Unidades: {$primera_fila['unidades']} <br>";
                        
                        // Mostrar el resto de tiendas
                        while ($row = $result->fetch_assoc()) {
                            echo "Tienda: {$row['tienda']} y Unidades: {$row['unidades']} <br>";
                        }
                        
                        
                    } else {
                        echo "<p>No hay stock de este producto en ninguna tienda.</p>";
                    }
                    
                    $stmt->close();
                }catch(mysqli_sql_exception $e){
                    echo "<p style='color:red'>Error al consultar el stock: " . $e->getMessage() . "</p>" ;

                }
            }
            elseif(isset($_POST['enviar'])){
                echo "<p>Por favor, selecciona un producto.</p>";

            }
            if (isset($connection)) {
                $connection->close();
            }
        ?>
    </div>
    <div id="pie">
        Desarrollo web entorno servidor Balbino
    </div>
</body>
</html>


<?php
try{
    $connection = new mysqli("localhost","dwes","abc123.","dwes");
    $connection -> set_charset("utf8mb4");
    $stmt = "SELECT nombre_corto FROM producto";
    $connection -> autocommit(false);
    $result = $connection -> query($stmt);

}catch(Exception $e){

}









?>