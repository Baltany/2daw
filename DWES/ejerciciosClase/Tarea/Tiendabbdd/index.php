<?php
$tienda = false;
$unidades = false;
$error= false;

if(isset($_POST['traspasar'])){

    if($_POST['tiendaOg'] != $_POST['tiendaDes']){
        $tienda=true;
    }
    if($_POST['unidades'] > 0){
        $unidades = true;
    }
}
if(isset($_POST['traspasar']) && $tienda && $unidades){
    try{
        $connection = new mysqli("localhost","dwes","abc123.","dwes");
        $connection -> set_charset("utf8mb4");
    }catch(mysqli_sql_exception $e){
        $error = true;
    }
    if(!$error){
        try{
            // como son dependientes una depende de la otra un saldo se suma y de la otra se resta de ahi que necesitemos el autocommit
            $connection -> autocommit(false);
            $connection -> query("UPDATE stock set unidades = unidades - $_POST[unidades] where tienda = $_POST[tiendaOg] and producto=$_POST[codPro] and unidades >= 0");
            if($connection -> affected_rows == 0){
                echo "error unidades";
            }else{
                $connection -> query("UPDATE stock set unidades = unidades + $_POST[unidades] where tienda = $_POST[tiendaDes] and producto=$_POST[codPro]");
                if($connection -> affected_rows==0){
                    $connection -> query("INSERT INTO stock values('$_POST[codPro]','$$_POST[tiendaDes]','$$_POST[unidades]')");
                }
                $connection -> commit();
            }
            $connection -> autocommit(true);
            echo "Traspaso correcto";

    
        }catch(mysqli_sql_exception $e){
            $connection -> rollback();
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
    tienda Destino <br>
    <select name="tiendaDes">
        <option value="1">Central</option>
        <option value="2">Sucursal1</option>
        <option value="3">Sucursal2</option>
    </select>
    <br>
    <?php if (isset($_POST['traspasar']) && !$tienda) echo "Las tiendas tienen que ser diferentes"?>
    <input type="text" name="codPro">Codigo producto <br>
    <input type="number" name="unidades">Unidades <?php if (isset($_POST['traspasar']) && !$unidades) echo "Las Unidades tienen que ser diferentes"?>
    <br>
    <input type="submit" name="traspasar" value="Traspasar">
</form>


<?php



}
?>