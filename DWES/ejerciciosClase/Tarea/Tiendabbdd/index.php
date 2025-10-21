<?php
$tienda = false;
$unidades = false;
$error = false;

if(isset($_POST['traspasar'])){
    if($_POST['tiendaOg'] != $_POST['tiendaDes']){
        $tienda = true;
    }
    if($_POST['unidades'] > 0){
        $unidades = true;
    }
}

if(isset($_POST['traspasar']) && $tienda && $unidades){
    try{
        $connection = new mysqli("localhost","dwes","abc123.","dwes");
        $connection->set_charset("utf8mb4");
    }catch(mysqli_sql_exception $e){
        $error = true;
        echo "Error de conexión: " . $e->getMessage();
    }
    
    if(!$error){
        try{
            $connection->autocommit(false);
            
            // IMPORTANTE: producto es VARCHAR, necesita comillas
            $sql1 = "UPDATE stock SET unidades = unidades - {$_POST['unidades']} 
                     WHERE tienda = {$_POST['tiendaOg']} 
                     AND producto = '{$_POST['codPro']}' 
                     AND unidades >= {$_POST['unidades']}";
            
            echo "SQL1: $sql1<br>"; // Para debug
            $connection->query($sql1);
            
            if($connection->affected_rows == 0){
                echo "Error: No hay suficientes unidades en la tienda origen o el producto no existe<br>";
                $connection->rollback();
            }else{
                $sql2 = "UPDATE stock SET unidades = unidades + {$_POST['unidades']} 
                         WHERE tienda = {$_POST['tiendaDes']} 
                         AND producto = '{$_POST['codPro']}'";
                
                echo "SQL2: $sql2<br>"; // Para debug
                $connection->query($sql2);
                
                if($connection->affected_rows == 0){
                    // No existe el registro, lo insertamos
                    $sql3 = "INSERT INTO stock VALUES('{$_POST['codPro']}', {$_POST['tiendaDes']}, {$_POST['unidades']})";
                    echo "SQL3: $sql3<br>"; // Para debug
                    $connection->query($sql3);
                }
                
                $connection->commit();
                echo "<strong>Traspaso correcto</strong><br>";
            }
            
            $connection->autocommit(true);
        }catch(mysqli_sql_exception $e){
            $connection->rollback();
            echo "Error en transacción: " . $e->getMessage() . "<br>";
        }
    }
}else{
?>

<form action="" method="post">
    Tienda Origen <br>
    <select name="tiendaOg">
        <option value="1">Central</option>
        <option value="2">Sucursal1</option>
        <option value="3">Sucursal2</option>
    </select>
    <br>
    Tienda Destino <br>
    <select name="tiendaDes">
        <option value="1">Central</option>
        <option value="2">Sucursal1</option>
        <option value="3">Sucursal2</option>
    </select>
    <br>
    <?php if (isset($_POST['traspasar']) && !$tienda) echo "<span style='color:red'>Las tiendas tienen que ser diferentes</span><br>"; ?>
    
    <input type="text" name="codPro" value="3DSNG"> Codigo producto <br>
    <input type="number" name="unidades" value="1"> Unidades 
    <?php if (isset($_POST['traspasar']) && !$unidades) echo "<span style='color:red'>Las unidades tienen que ser mayores a 0</span>"; ?>
    <br>
    <input type="submit" name="traspasar" value="Traspasar">
</form>

<?php
}
?>